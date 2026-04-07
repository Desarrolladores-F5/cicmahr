<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\TipoDocumento;
use App\Jobs\ProcesarDocumentosMasivos;
use App\Models\ProcesoCarga;

class DocumentoController extends Controller
{
    public function store(Request $request, Trabajador $trabajador) // para subir un documento asociado a un trabajador
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {  // 🔒 Seguridad: solo pueden subir documentos a trabajadores de su empresa
            abort(403);
        }

        $request->validate([                                             // 🔍 Validación de campos
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'fecha_documento'   => 'nullable|date',
            'observaciones'     => 'nullable|string|max:1000',
            'archivo'           => 'required|file|mimes:pdf|max:5120',
        ]);

        $archivo = $request->file('archivo');                        // 📁 Guardar archivo en almacenamiento público organizado por empresa y trabajador

        $path = $archivo->store(                                       
            "documentos/empresa_{$trabajador->empresa_id}/trabajador_{$trabajador->id}",
            'public'
        );

        // 🔎 detectar tipo automáticamente
        $tipoId = $this->detectarTipoDocumentoId($archivo->getClientOriginalName());

        // fallback si no detecta
        if (!$tipoId) {
            $tipoOtros = TipoDocumento::firstOrCreate([
                'nombre_documento' => 'Otros documentos'
            ]);

            $tipoId = $tipoOtros->id;
        }

        Documento::create([
            'trabajador_id'     => $trabajador->id,
            'tipo_documento_id' => $tipoId,
            'ruta_archivo'      => $path,
            'fecha_documento'   => now(),
            'observaciones'     => 'Documento subido'
        ]);

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'documentos',
            'crear',
            'Se subió un documento para ' . $trabajador->nombre . ' ' . $trabajador->apellido
        );

        return back()->with('success', 'Documento subido correctamente.');
    }

    public function destroy(Trabajador $trabajador, Documento $documento)  // para eliminar un documento asociado a un trabajador
    {
        // 🔒 Seguridad: empresa + documento pertenece a ese trabajador
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) abort(403);
        if ($documento->trabajador_id !== $trabajador->id) abort(404);

        // 🧹 Borrar archivo físico
        if ($documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->delete();

        registrarActividad(
            'documentos',
            'eliminar',
            'Se eliminó documento de ' . $trabajador->nombre . ' ' . $trabajador->apellido
        );

        return back()->with('success', 'Documento eliminado.');
    }

    public function download(Trabajador $trabajador, Documento $documento)  // para descargar un documento asociado a un trabajador
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) abort(403);
        if ($documento->trabajador_id !== $trabajador->id) abort(404);

        $filename = "trabajador_{$trabajador->rut}_doc_{$documento->id}.pdf";

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'documentos',
            'descargar',
            'Se descargó un documento de ' . $trabajador->nombre . ' ' . $trabajador->apellido
        );

        return Storage::disk('public')->download($documento->ruta_archivo, $filename);
    }

    public function createCargaMasiva()   // para mostrar formulario de carga masiva de documentos
    {
        return view('admin.documentos.carga_masiva');
    }

    public function storeCargaMasiva(Request $request)
    {
        $request->validate([
            'archivos.*' => 'file|mimes:pdf,zip|max:20480'
        ]);

        $empresaId = auth()->user()->empresa_id;

        $archivosProcesar = [];

        foreach ($request->file('archivos') as $archivo) {

            if ($archivo->extension() === 'zip') {

                $zip = new \ZipArchive;
                $path = $archivo->getRealPath();

                if ($zip->open($path) === TRUE) {

                    for ($i = 0; $i < $zip->numFiles; $i++) {

                        $nombreArchivo = $zip->getNameIndex($i);

                        if (!str_ends_with(strtolower($nombreArchivo), '.pdf')) {
                            continue;
                        }

                        Storage::disk('local')->makeDirectory('temp');

                        $tempPath = 'temp/' . uniqid() . '_' . basename($nombreArchivo);

                        Storage::disk('local')->put(
                            $tempPath,
                            $zip->getFromIndex($i)
                        );

                        $archivosProcesar[] = [
                            'nombre' => $nombreArchivo,
                            'ruta' => $tempPath
                        ];
                    }

                    $zip->close();
                }

            } else {

                $nombreArchivo = $archivo->getClientOriginalName();

                $tempPath = 'temp/' . uniqid() . '_' . $nombreArchivo;

                Storage::disk('local')->put($tempPath, file_get_contents($archivo->getRealPath()));

                $archivosProcesar[] = [
                    'nombre' => $nombreArchivo,
                    'ruta' => $tempPath
                ];
            }
        }

        // Crear proceso
        $proceso = ProcesoCarga::create([
            'empresa_id' => $empresaId,
            'total_archivos' => count($archivosProcesar),
            'procesados' => 0,
            'asignados' => 0,
            'no_encontrados' => 0,
            'estado' => 'procesando'
        ]);

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'documentos',
            'carga_masiva',
            'Se inició una carga masiva de documentos (' . count($archivosProcesar) . ' archivos)'
        );

        // Lanzar Job
        ProcesarDocumentosMasivos::dispatch($archivosProcesar, $empresaId, $proceso->id);

        return redirect()->route('admin.carga.progreso', $proceso->id);
    }

    private function procesarDocumento($nombreArchivo, $contenido, $empresaId, &$asignados, &$noEncontrados)   // lógica para procesar cada documento, extraer RUT, buscar trabajador y guardar documento
    {
        if (!preg_match('/(\d{7,8}-[0-9K])/i', $nombreArchivo, $matches)) {
            return;
        }
        
        $trabajador = Trabajador::where('empresa_id', $empresaId)
            ->where('rut', $rut)
            ->first();

        if (!$trabajador) {
            $noEncontrados[] = $rut;
            return;
        }

        $ruta = "documentos/empresa_{$empresaId}/trabajador_{$trabajador->id}/" . $nombreArchivo;

        Storage::disk('public')->put($ruta, $contenido);

        $tipoId = $this->detectarTipoDocumentoId($nombreArchivo);

        if (!$tipoId) {
            $tipoOtros = TipoDocumento::firstOrCreate([
                'nombre_documento' => 'Otros documentos'
            ]);
            $tipoId = $tipoOtros->id;
        }

        Documento::create([
            'trabajador_id' => $trabajador->id,
            'tipo_documento_id' => $tipoId,
            'fecha_documento' => now(),
            'ruta_archivo' => $ruta,
            'observaciones' => 'Carga masiva'
        ]);

        $asignados++;
    }

    private function detectarTipoDocumentoId(string $filename): ?int  // lógica para detectar tipo de documento a partir del nombre del archivo, buscando palabras clave como "liquidacion", "contrato", etc. y asignar el ID correspondiente
    {
        $name = strtolower($filename);

        $map = [
            'liquidacion' => 'Liquidación de sueldo',
            'contrato'    => 'Contrato',
            'anexo'       => 'Anexo',
            'finiquito'   => 'Finiquito',
            'vacaciones'  => 'Vacaciones',
            'licencia'    => 'Licencia',
            'certificado' => 'Certificado',
        ];

        foreach ($map as $keyword => $tipoNombre) {
            if (str_contains($name, $keyword)) {
                $tipo = \App\Models\TipoDocumento::where('nombre_documento', $tipoNombre)->first();
                return $tipo?->id;
            }
        }

        return null; // si no lo pudo detectar
    }

    public function progreso($id)
    {
        $proceso = ProcesoCarga::findOrFail($id);

        return view('admin.documentos.progreso', compact('proceso'));
    }
}