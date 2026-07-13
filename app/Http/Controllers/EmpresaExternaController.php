<?php

namespace App\Http\Controllers;

use App\Models\EmpresaExterna;
use App\Http\Requests\StoreEmpresaExternaRequest;
use Illuminate\Http\RedirectResponse;

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
        //
    }

    // ======================================================
    // ✏ EDICIÓN
    // ======================================================

    public function edit(EmpresaExterna $empresaExterna)
    {
        //
    }

    public function update(Request $request, EmpresaExterna $empresaExterna)
    {
        //
    }

    // ======================================================
    // 🗑 ELIMINACIÓN
    // ======================================================

    public function destroy(EmpresaExterna $empresaExterna)
    {
        //
    }
}