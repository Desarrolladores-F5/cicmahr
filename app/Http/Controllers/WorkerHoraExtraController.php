<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HoraExtra;

class WorkerHoraExtraController extends Controller
{
    public function index()   // Muestra al trabajador sus horas extras registradas y el total del mes actual
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
        $horasSemanales = $trabajador->horas_semanales ?? 42;

        // Valor hora ordinaria
        $valorHora = (
            (($trabajador->sueldo / 30) * 28)
            /
            ($horasSemanales * 4)
        );

        // Hora extra = 50% recargo
        $valorHoraExtra = $valorHora * 1.5;

        // Monto total estimado
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

    public function store(Request $request)   // Permite a un trabajador solicitar horas extras
    {
        $trabajador = auth()->user()->trabajador;

        $request->validate([
            'fecha' => 'required|date',
            'horas' => 'required|numeric|min:0.5|max:2',
            'motivo' => 'nullable|string|max:255',
        ]);

        $horaExtra = HoraExtra::create([
            'trabajador_id' => $trabajador->id,
            'fecha' => $request->fecha,
            'horas' => $request->horas,
            'motivo' => $request->motivo,
            'estado' => 'pendiente'
        ]);

        return back()->with('success', 'Solicitud enviada.');
    }
}

