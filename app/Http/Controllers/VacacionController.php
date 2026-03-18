<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VacacionController extends Controller
{
    public function store(Request $request)
    {
        // Calcular días
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        $dias = $inicio->diffInDays($fin) + 1;

        Vacacion::create([
            'trabajador_id' => auth()->user()->trabajador->id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'dias_solicitados' => $dias,
            'comentario_trabajador' => $request->comentario,
        ]);

        return back()->with('success', 'Solicitud enviada correctamente');
    }

    public function indexAdmin()
    {
        $vacaciones = Vacacion::with('trabajador')->latest()->get();

        return view('admin.vacaciones.index', compact('vacaciones'));
    }
}