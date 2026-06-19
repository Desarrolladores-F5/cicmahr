<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $totalTrabajadores = Trabajador::where('empresa_id', $empresaId)->count();

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

        // 🔔 Contratos por vencer
        $hoy = Carbon::today();

        $contratosPorVencer = Trabajador::where('empresa_id', $empresaId)
            ->where('estado', 'vigente')
            ->where('tipo_contrato', 'plazo_fijo')
            ->whereNotNull('fecha_salida')
            ->whereDate('fecha_salida', '<=', $hoy->copy()->addDays(30))
            ->orderBy('fecha_salida')
            ->get()
            ->map(function ($trabajador) use ($hoy) {
                $fechaSalida = Carbon::parse($trabajador->fecha_salida);

                $trabajador->dias_restantes = $hoy->diffInDays($fechaSalida, false);

                return $trabajador;
            });

        $totalContratosPorVencer = $contratosPorVencer->count();

        return view('admin.dashboard', compact(
            'totalTrabajadores',
            'vigentes',
            'inactivos',
            'plazoFijo',
            'indefinido',
            'contratosPorVencer',
            'totalContratosPorVencer'
        ));
    }
}