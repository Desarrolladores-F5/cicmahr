<?php

namespace App\Http\Controllers;

use App\Models\EmpresaExterna;
use App\Models\EmpresaExternaDocumento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmpresaExternaDocumentoRequest;
use Illuminate\Support\Facades\Storage;

class EmpresaExternaDocumentoController extends Controller
{
    // ======================================================
    // 📋 LISTADO DE DOCUMENTOS
    // ======================================================

    public function index(EmpresaExterna $empresaExterna)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 📄 DOCUMENTOS DE LA EMPRESA EXTERNA
        // ======================================================

        $documentos = $empresaExterna->documentos()
            ->orderBy('nombre_documento')
            ->get();

        return view(
            'admin.contratos-externos.empresas.documentos.index',
            compact('empresaExterna', 'documentos')
        );
    }

    // ======================================================
    // ➕ FORMULARIO PARA SUBIR DOCUMENTO
    // ======================================================

    public function create(EmpresaExterna $empresaExterna)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        return view(
            'admin.contratos-externos.empresas.documentos.create',
            compact('empresaExterna')
        );
    }

    // ======================================================
    // 💾 GUARDAR DOCUMENTO
    // ======================================================

    public function store(StoreEmpresaExternaDocumentoRequest $request,EmpresaExterna $empresaExterna)    
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 📎 GUARDAR ARCHIVO
        // ======================================================

        $rutaArchivo = $request->file('archivo')->store(
            'empresas-externas/' . $empresaExterna->id . '/documentos',
            'public'
        );

        // ======================================================
        // 📄 REGISTRAR DOCUMENTO
        // ======================================================

        $empresaExterna->documentos()->create([
            'nombre_documento' => $request->nombre_documento,
            'tipo_documento'   => $request->tipo_documento,
            'archivo'          => $rutaArchivo,
            'observaciones'    => $request->observaciones,
        ]);

        // ======================================================
        // ↩️ VOLVER AL EXPEDIENTE DOCUMENTAL
        // ======================================================

        return redirect()
            ->route(
                'admin.contratos-externos.empresas.documentos.index',
                $empresaExterna
            )
            ->with(
                'success',
                'Documento registrado correctamente.'
            );
        
    }

    // ======================================================
    // 👁 VER DOCUMENTO
    // ======================================================

    public function show(EmpresaExterna $empresaExterna, EmpresaExternaDocumento $documento)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 🔐 VALIDAR PERTENENCIA DEL DOCUMENTO
        // ======================================================

        abort_unless(
            $documento->empresa_externa_id === $empresaExterna->id,
            403
        );

        // ======================================================
        // 📄 VALIDAR EXISTENCIA DEL ARCHIVO
        // ======================================================

        abort_unless(
            Storage::disk('public')->exists($documento->archivo),
            404
        );

        // ======================================================
        // 👁 MOSTRAR ARCHIVO EN EL NAVEGADOR
        // ======================================================

        return response()->file(
            Storage::disk('public')->path($documento->archivo)
        );
    }


    // ======================================================
    // ⬇ DESCARGAR DOCUMENTO
    // ======================================================

    public function download(EmpresaExterna $empresaExterna, EmpresaExternaDocumento $documento)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 🔐 VALIDAR PERTENENCIA DEL DOCUMENTO
        // ======================================================

        abort_unless(
            $documento->empresa_externa_id === $empresaExterna->id,
            403
        );

        // ======================================================
        // 📄 VALIDAR EXISTENCIA DEL ARCHIVO
        // ======================================================

        abort_unless(
            Storage::disk('public')->exists($documento->archivo),
            404
        );

        // ======================================================
        // ⬇ DESCARGAR ARCHIVO
        // ======================================================

        $extension = pathinfo($documento->archivo, PATHINFO_EXTENSION);

        $nombreDescarga = $documento->nombre_documento . '.' . $extension;

        return Storage::disk('public')->download(
            $documento->archivo,
            $nombreDescarga
        );
    }

    // ======================================================
    // 🗑️ ELIMINAR DOCUMENTO
    // ======================================================

    public function destroy(EmpresaExterna $empresaExterna, EmpresaExternaDocumento $documento)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // 🔐 VALIDAR PERTENENCIA DEL DOCUMENTO
        // ======================================================

        abort_unless(
            $documento->empresa_externa_id === $empresaExterna->id,
            403
        );

        // ======================================================
        // 📄 ELIMINAR ARCHIVO FÍSICO
        // ======================================================

        if (Storage::disk('public')->exists($documento->archivo)) {

            Storage::disk('public')->delete($documento->archivo);

        }

        // ======================================================
        // 🗃️ ELIMINAR REGISTRO DE BASE DE DATOS
        // ======================================================

        $documento->delete();

        // ======================================================
        // ↩️ VOLVER AL EXPEDIENTE DOCUMENTAL
        // ======================================================

        return redirect()
            ->route(
                'admin.contratos-externos.empresas.documentos.index',
                $empresaExterna
            )
            ->with(
                'success',
                'Documento eliminado correctamente.'
            );
    }
}