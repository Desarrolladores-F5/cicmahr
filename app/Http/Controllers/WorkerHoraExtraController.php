<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HoraExtra;

class WorkerHoraExtraController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener trabajador asociado al usuario
        $trabajador = $user->trabajador;

        $horasExtras = HoraExtra::where('trabajador_id', $trabajador->id)
            ->latest('fecha')
            ->get();

        $totalMesActual = HoraExtra::where('trabajador_id', $trabajador->id)
            ->where('estado','aprobado')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('horas');

        // 🔹 Cálculo según normativa chilena
        $horasSemanales = 40;
        $horasDiarias = $horasSemanales / 5;

        $valorHora = $trabajador->sueldo / 30 / $horasDiarias;
        $valorHoraExtra = $valorHora * 1.5;

        $montoHorasExtras = $valorHoraExtra * $totalMesActual;

        return view('worker.horas_extras.index', compact(
            'trabajador',
            'horasExtras',
            'totalMesActual',
            'valorHora',
            'valorHoraExtra',
            'montoHorasExtras'
        ));
    }
}

