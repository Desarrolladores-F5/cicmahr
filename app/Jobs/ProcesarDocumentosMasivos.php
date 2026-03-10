<?php

namespace App\Jobs;

use App\Models\Trabajador;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\ProcesoCarga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcesarDocumentosMasivos implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $archivos;
    protected $empresaId;
    protected $procesoId;

    public function __construct($archivos, $empresaId, $procesoId)
    {
        $this->archivos = $archivos;
        $this->empresaId = $empresaId;
        $this->procesoId = $procesoId;
    }

    public function handle()
    {   
       
        $proceso = ProcesoCarga::find($this->procesoId);

        if (!$proceso) {
            return;
        }

        foreach ($this->archivos as $archivo) {

            $nombreArchivo = $archivo['nombre'];
            $rutaTemporal = $archivo['ruta'];

            $fullPath = Storage::disk('local')->path($rutaTemporal);

            if (!file_exists($fullPath)) {
                $proceso->increment('no_encontrados');
                continue;
            }

            $contenido = file_get_contents($fullPath);

            $this->procesarDocumento($nombreArchivo, $contenido, $proceso);

            // limpiar archivo temporal
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $proceso->update([
            'estado' => 'completado'
        ]);
    }

    private function procesarDocumento($nombreArchivo, $contenido, $proceso)
    {

        $proceso->increment('procesados');

        $nombreArchivo = basename($nombreArchivo);

        if (!preg_match('/(\d{7,8}-[0-9K])/', $nombreArchivo, $matches)) {      

            $proceso->increment('no_encontrados');
            return;
        }

        $rut = strtoupper(trim($matches[1]));
        $rut = str_replace('.', '', $rut);

        $trabajador = Trabajador::where('empresa_id', $this->empresaId)
            ->whereRaw("REPLACE(rut,'.','') = ?", [$rut])
            ->first();

        if (!$trabajador) {

            $proceso->increment('no_encontrados');
            return;
        }

        $ruta = "documentos/empresa_{$this->empresaId}/trabajador_{$trabajador->id}/" . $nombreArchivo;

        Storage::disk('public')->put($ruta, $contenido);

        $tipoId = $this->detectarTipoDocumentoId($nombreArchivo);

        Documento::create([
            'trabajador_id' => $trabajador->id,
            'tipo_documento_id' => $tipoId,
            'fecha_documento' => now(),
            'ruta_archivo' => $ruta,
            'observaciones' => 'Carga masiva'
        ]);

        // contador asignados
        $proceso->increment('asignados');
    }

    private function detectarTipoDocumentoId($filename)
    {
        $name = strtolower($filename);

        $map = [
            'liquidacion' => 'Liquidación de sueldo',
            'contrato' => 'Contrato',
            'anexo' => 'Anexo de contrato'
        ];

        foreach ($map as $keyword => $tipoNombre) {

            if (str_contains($name, $keyword)) {

                $tipo = TipoDocumento::where('nombre_documento', $tipoNombre)->first();

                return $tipo?->id;
            }
        }

        return TipoDocumento::where('nombre_documento', 'Otros documentos')->first()?->id;
    }
}