<?php

namespace App\Http\Controllers;

use App\Models\Honorario;
use App\Models\HonorarioDocumento;
use App\Models\HonorarioContrato;
use Illuminate\View\View;
use App\Http\Requests\StoreHonorarioRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreHonorarioContratoRequest;
use App\Http\Requests\StoreHonorarioDocumentoRequest;
use App\Http\Requests\StoreHonorarioContratoArchivoRequest;


class HonorarioController extends Controller
{
    // ======================================================
    // 👥 LISTADO DE PRESTADORES A HONORARIOS
    // ======================================================

    public function index(): View
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        $empresaId = auth()->user()->empresa_id;

        // ======================================================
        // 👤 PRESTADORES DE LA EMPRESA AUTENTICADA
        // ======================================================

        $honorarios = Honorario::query()
            ->where('empresa_id', $empresaId)
            ->with('contratos')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        // ======================================================
        // 📊 MÉTRICAS DEL MÓDULO
        // ======================================================

        $totalPrestadores = $honorarios->count();

        $contratosActivos = $honorarios
            ->flatMap->contratos
            ->filter(fn ($contrato) => $contrato->estado === 'vigente')
            ->count();

        $contratosPorVencer = $honorarios
            ->flatMap->contratos
            ->filter(function ($contrato) {

                if ($contrato->estado !== 'vigente') {
                    return false;
                }

                return now()->startOfDay()
                    ->diffInDays($contrato->fecha_termino, false) <= 20;
            })
            ->count();

        // ======================================================
        // 📄 VISTA PRINCIPAL
        // ======================================================

        return view(
            'admin.contratos-externos.honorarios.index',
            compact(
                'honorarios',
                'totalPrestadores',
                'contratosActivos',
                'contratosPorVencer'
            )
        );
    }

    // ======================================================
    // ➕ FORMULARIO PARA REGISTRAR PRESTADOR
    // ======================================================

    public function create(): View
    {
        return view('admin.contratos-externos.honorarios.create');
    }

    // ======================================================
    // 💾 GUARDAR PRESTADOR Y PRIMER CONTRATO
    // ======================================================

    public function store(StoreHonorarioRequest $request): RedirectResponse
    {
        // ======================================================
        // 🔐 EMPRESA AUTENTICADA
        // ======================================================

        $empresaId = auth()->user()->empresa_id;

        // ======================================================
        // ✅ DATOS VALIDADOS
        // ======================================================

        $datos = $request->validated();

        // ======================================================
        // 🔄 TRANSACCIÓN
        // ======================================================

        DB::transaction(function () use ($datos, $empresaId) {

            // ==================================================
            // 👤 CREAR PRESTADOR
            // ==================================================

            $honorario = Honorario::create([
                'empresa_id' => $empresaId,
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'rut' => $datos['rut'],
                'profesion_oficio' => $datos['profesion_oficio'],
                'direccion' => $datos['direccion'],
                'correo' => $datos['correo'],
                'telefono' => $datos['telefono'],
            ]);

            // ==================================================
            // 📑 CREAR PRIMER CONTRATO
            // ==================================================

            $honorario->contratos()->create([
                'cargo' => $datos['cargo'],
                'monto_honorario' => $datos['monto_honorario'],
                'fecha_inicio' => $datos['fecha_inicio'],
                'fecha_termino' => $datos['fecha_termino'],
                'hora_inicio' => $datos['hora_inicio'],
                'hora_termino' => $datos['hora_termino'],
                'horas_semanales' => $datos['horas_semanales'],
            ]);
        });

        // ======================================================
        // ↩️ VOLVER AL LISTADO
        // ======================================================

        return redirect()
            ->route('admin.contratos-externos.honorarios.index')
            ->with('success', 'Prestador registrado correctamente.');
    }

    // ======================================================
    // 👁️ VER EXPEDIENTE DEL PRESTADOR
    // ======================================================

    public function show(Honorario $honorario): View
    {
        // ==================================================
        // 🔐 BLINDAJE MULTIEMPRESA
        // ==================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ==================================================
        // 📑 CARGAR HISTORIAL DE CONTRATOS
        // ==================================================

        $honorario->load([
            'contratos' => function ($query) {
                $query->orderByDesc('fecha_inicio');
            },
            
            'documentos' => function ($query) {
                $query->orderByDesc('created_at');
            },
        ]);

        // ==================================================
        // 🟢 CONTRATO VIGENTE
        // ==================================================

        $contratoVigente = $honorario->contratos
            ->first(fn ($contrato) => $contrato->estado === 'vigente');

        // ==================================================
        // 👁️ MOSTRAR EXPEDIENTE
        // ==================================================

        return view(
            'admin.contratos-externos.honorarios.show',
            compact('honorario', 'contratoVigente')
        );
    }

    // ======================================================
    // ➕ FORMULARIO PARA NUEVO CONTRATO
    // ======================================================

    public function createContrato(Honorario $honorario): View
    {
        // ==================================================
        // 🔐 BLINDAJE MULTIEMPRESA
        // ==================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ==================================================
        // ➕ MOSTRAR FORMULARIO
        // ==================================================

        return view(
            'admin.contratos-externos.honorarios.contratos.create',
            compact('honorario')
        );
    }

    /**
     * Guarda un nuevo contrato para un prestador a honorarios.
     */
    public function storeContrato(StoreHonorarioContratoRequest $request, Honorario $honorario): RedirectResponse 
    {

        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 📑 CREAR NUEVO CONTRATO
        // ======================================================

        $honorario->contratos()->create(
            $request->validated()
        );

        // ======================================================
        // ✅ VOLVER AL EXPEDIENTE
        // ======================================================

        return redirect()
            ->route('admin.contratos-externos.honorarios.show', $honorario)
            ->with('success', 'Contrato registrado correctamente.');
    }

    /*** Muestra el formulario para subir un documento al expediente del prestador a honorarios.*/
    public function createDocumento(Honorario $honorario): View
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 📁 FORMULARIO DE DOCUMENTO
        // ======================================================

        return view(
            'admin.contratos-externos.honorarios.documentos.create',
            compact('honorario')
        );
    }

    /*** Guarda un nuevo documento en el expediente del prestador a honorarios.*/
    public function storeDocumento(StoreHonorarioDocumentoRequest $request, Honorario $honorario): RedirectResponse 
    {

        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 📎 ARCHIVO VALIDADO
        // ======================================================

        $archivo = $request->file('archivo');

        $nombreOriginal = $archivo->getClientOriginalName();

        // ======================================================
        // 🔐 ALMACENAMIENTO PRIVADO
        // ======================================================

        $rutaArchivo = $archivo->store(
            'honorarios/' . $honorario->id . '/documentos',
            'local'
        );

        // ======================================================
        // 🗄️ REGISTRAR DOCUMENTO
        // ======================================================

        try {

            $honorario->documentos()->create([
                'tipo' => $request->validated('tipo'),
                'nombre_original' => $nombreOriginal,
                'ruta_archivo' => $rutaArchivo,
            ]);

        } catch (\Throwable $e) {

            // Si falla la base de datos, eliminamos el archivo
            // para no dejar documentos huérfanos.

            Storage::disk('local')->delete($rutaArchivo);

            throw $e;
        }

        // ======================================================
        // ✅ VOLVER AL EXPEDIENTE
        // ======================================================

        return redirect()
            ->route('admin.contratos-externos.honorarios.show', $honorario)
            ->with('success', 'Documento guardado correctamente.');
    }

    /*** Muestra un documento privado perteneciente al expediente del prestador a honorarios.*/
    public function verDocumento(Honorario $honorario, HonorarioDocumento $documento) 
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 🔐 VALIDAR PERTENENCIA DEL DOCUMENTO
        // ======================================================

        abort_unless(
            $documento->honorario_id === $honorario->id,
            403
        );

        // ======================================================
        // 📄 COMPROBAR EXISTENCIA DEL ARCHIVO
        // ======================================================

        abort_unless(
            Storage::disk('local')->exists($documento->ruta_archivo),
            404
        );

        // ======================================================
        // 👁️ MOSTRAR ARCHIVO PRIVADO
        // ======================================================

        return Storage::disk('local')->response(
            $documento->ruta_archivo,
            $documento->nombre_original
        );
    }

    /*** Elimina un documento del expediente del prestador y su archivo físico del almacenamiento privado.*/
    public function destroyDocumento(Honorario $honorario, HonorarioDocumento $documento): RedirectResponse 
    {

        // 🔐 El prestador debe pertenecer a la empresa autenticada
        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // 🔐 El documento debe pertenecer al prestador indicado
        abort_unless(
            $documento->honorario_id === $honorario->id,
            403
        );

        $rutaArchivo = $documento->ruta_archivo;

        // 🗑 Eliminar primero el archivo físico privado
        if (Storage::disk('local')->exists($rutaArchivo)) {
            $eliminado = Storage::disk('local')->delete($rutaArchivo);

            if (!$eliminado) {
                return redirect()
                    ->route('admin.contratos-externos.honorarios.show', $honorario)
                    ->with(
                        'error',
                        'No se pudo eliminar el archivo físico del documento.'
                    );
            }
        }

        // 🗄 Eliminar el registro de la base de datos
        $documento->delete();

        return redirect()
            ->route('admin.contratos-externos.honorarios.show', $honorario)
            ->with('success', 'Documento eliminado correctamente.');
    }

    /** Guarda el PDF firmado asociado a un contrato específico del prestador.*/
    public function storeArchivoContrato(StoreHonorarioContratoArchivoRequest $request, Honorario $honorario, HonorarioContrato $contrato): RedirectResponse 
    {

        // 🔐 El prestador debe pertenecer a la empresa autenticada
        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // 🔐 El contrato debe pertenecer al prestador indicado
        abort_unless(
            $contrato->honorario_id === $honorario->id,
            403
        );

        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();

        // 📁 Guardar el contrato firmado en almacenamiento privado
        $rutaArchivo = $archivo->store(
            'honorarios/' . $honorario->id . '/contratos/' . $contrato->id,
            'local'
        );

        try {
            $contrato->update([
                'nombre_archivo_contrato' => $nombreOriginal,
                'ruta_archivo_contrato' => $rutaArchivo,
            ]);
        } catch (\Throwable $e) {
            // Si falla la BD, eliminamos el archivo recién creado
            // para no dejar un fiambre en storage.
            Storage::disk('local')->delete($rutaArchivo);

            throw $e;
        }

        return redirect()
            ->route('admin.contratos-externos.honorarios.show', $honorario)
            ->with('success', 'Contrato firmado guardado correctamente.');
    }

    /** Muestra el PDF firmado asociado a un contrato específico del prestador.*/
    public function verArchivoContrato(Honorario $honorario, HonorarioContrato $contrato) 
    {
        // 🔐 El prestador debe pertenecer a la empresa autenticada
        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // 🔐 El contrato debe pertenecer al prestador indicado
        abort_unless(
            $contrato->honorario_id === $honorario->id,
            403
        );

        // 📄 El contrato debe tener un archivo asociado
        abort_unless(
            $contrato->ruta_archivo_contrato,
            404
        );

        // 🔐 El archivo físico debe existir en almacenamiento privado
        abort_unless(
            Storage::disk('local')->exists($contrato->ruta_archivo_contrato),
            404
        );

        return Storage::disk('local')->response(
            $contrato->ruta_archivo_contrato,
            $contrato->nombre_archivo_contrato
        );
    }

    /* Elimina el PDF firmado asociado a un contrato, manteniendo intacto el registro contractual. */
    public function destroyArchivoContrato(Honorario $honorario, HonorarioContrato $contrato): RedirectResponse 
    {

        // 🔐 El prestador debe pertenecer a la empresa autenticada
        abort_unless(
            $honorario->empresa_id === auth()->user()->empresa_id,
            403
        );

        // 🔐 El contrato debe pertenecer al prestador indicado
        abort_unless(
            $contrato->honorario_id === $honorario->id,
            403
        );

        $rutaArchivo = $contrato->ruta_archivo_contrato;

        // 🗑 Eliminar el archivo físico privado si existe
        if ($rutaArchivo && Storage::disk('local')->exists($rutaArchivo)) {

            $eliminado = Storage::disk('local')->delete($rutaArchivo);

            if (!$eliminado) {
                return redirect()
                    ->route('admin.contratos-externos.honorarios.show', $honorario)
                    ->with(
                        'error',
                        'No se pudo eliminar el archivo físico del contrato firmado.'
                    );
            }
        }

        // 🧹 Limpiar solamente la referencia al PDF.
        // El contrato y su historial permanecen intactos.
        $contrato->update([
            'nombre_archivo_contrato' => null,
            'ruta_archivo_contrato' => null,
        ]);

        return redirect()
            ->route('admin.contratos-externos.honorarios.show', $honorario)
            ->with('success', 'Contrato firmado eliminado correctamente.');
    }
}