<?php

namespace App\Http\Controllers;

use App\Models\EmpresaExterna;
use App\Http\Requests\StoreEmpresaExternaRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateEmpresaExternaRequest;

class EmpresaExternaController extends Controller
{
    // ======================================================
    // 📋 LISTADO
    // ======================================================

    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $empresasExternas = EmpresaExterna::where('empresa_id', $empresaId)
            ->orderBy('razon_social')
            ->get();

        
        return view(
            'admin.contratos-externos.empresas.index',
            compact('empresasExternas')
        );
    }

    // ======================================================
    // ➕ REGISTRO
    // ======================================================

    public function create()
    {
        return view('admin.contratos-externos.empresas.create');
    }

    // ======================================================
    // ➕ REGISTRO
    // ======================================================

    public function store(StoreEmpresaExternaRequest $request): RedirectResponse
    {
        EmpresaExterna::create([

            'empresa_id' => auth()->user()->empresa_id,

            ...$request->validated(),

        ]);

        return redirect()
            ->route('admin.contratos-externos.empresas.index')
            ->with(
                'success',
                'La empresa externa fue registrada correctamente.'
            );
    }

    public function show(EmpresaExterna $empresaExterna)
    {
        return view(
            'admin.contratos-externos.empresas.show',
            compact('empresaExterna')
        );
    }

    // ======================================================
    // ✏️ EDITAR EMPRESA EXTERNA
    // ======================================================

    public function edit(EmpresaExterna $empresaExterna)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        return view(
            'admin.contratos-externos.empresas.edit',
            compact('empresaExterna')
        );
    }

    // ======================================================
    // 💾 ACTUALIZAR EMPRESA EXTERNA
    // ======================================================

    public function update(UpdateEmpresaExternaRequest $request, EmpresaExterna $empresaExterna)
    {
        // ======================================================
        // 🔐 SEGURIDAD MULTIEMPRESA
        // ======================================================

        abort_unless(
            $empresaExterna->empresa_id === auth()->user()->empresa_id,
            403
        );

        // ======================================================
        // ✅ DATOS VALIDADOS
        // ======================================================

        $datos = $request->validated();

        // ======================================================
        // 💾 ACTUALIZAR EMPRESA EXTERNA
        // ======================================================

        $empresaExterna->update($datos);

        // ======================================================
        // ↩️ VOLVER AL EXPEDIENTE
        // ======================================================

        return redirect()
            ->route(
                'admin.contratos-externos.empresas.show',
                $empresaExterna
            )
            ->with(
                'success',
                'Empresa externa actualizada correctamente.'
            );
    }

    // ======================================================
    // 🗑 ELIMINACIÓN
    // ======================================================

    public function destroy(EmpresaExterna $empresaExterna)
    {
        //
    }
}