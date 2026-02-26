<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $total = Trabajador::where('empresa_id', $empresaId)->count();

        $vigentes = Trabajador::where('empresa_id', $empresaId)
            ->where('estado', 'vigente')
            ->count();

        $inactivos = Trabajador::where('empresa_id', $empresaId)
            ->where('estado', 'no_vigente')
            ->count();

        $plazoFijo = Trabajador::where('empresa_id', $empresaId)
            ->where('tipo_contrato', 'plazo_fijo')
            ->count();

        $indefinido = Trabajador::where('empresa_id', $empresaId)
            ->where('tipo_contrato', 'indefinido')
            ->count();

        return view('dashboard', compact(
            'total',
            'vigentes',
            'inactivos',
            'plazoFijo',
            'indefinido'
        ));
    }
}