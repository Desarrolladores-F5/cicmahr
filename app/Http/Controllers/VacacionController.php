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

    public function indexAdmin()    // muestra listado de solicitudes de vacaciones de trabajadores para que el admin aprueba o rechazar
    {
        $vacaciones = Vacacion::with('trabajador')->latest()->get();

        return view('admin.vacaciones.index', compact('vacaciones'));
    }

    public function aprobar(Request $request, Vacacion $vacacion)    // el admin aprueba la solicitud de vacaciones
    {
        $vacacion->update([
            'estado' => 'aprobado',
            'comentario_admin' => $request->comentario_admin,
            'fecha_respuesta' => now()
        ]);

        return back()->with('success', 'Vacación aprobada correctamente');
    }

    public function rechazar(Request $request, Vacacion $vacacion)   // el admin rechaza la solicitud de vacaciones
    {
        $vacacion->update([
            'estado' => 'rechazado',
            'comentario_admin' => $request->comentario_admin,
            'fecha_respuesta' => now()
        ]);

        return back()->with('success', 'Vacación rechazada correctamente');
    }

    public function indexWorker()    // muestra listado de solicitudes de vacaciones del trabajador autenticado
    {
        $trabajador = auth()->user()->trabajador;

        $vacaciones = Vacacion::where('trabajador_id', $trabajador->id)
            ->latest()
            ->get();

        return view('worker.vacaciones.index', compact('vacaciones'));
    }
}