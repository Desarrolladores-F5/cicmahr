<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VacacionController extends Controller
{
    public function store(Request $request)    // el trabajador solicita vacaciones
    {
        // Calcular días
        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        $dias = $inicio->diffInDays($fin) + 1;

        $trabajador = auth()->user()->trabajador;

        $vacacion = Vacacion::create([
            'trabajador_id' => $trabajador->id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'dias_solicitados' => $dias,
            'comentario_trabajador' => $request->comentario,
        ]);

        // 🔥 AUDITORÍA
        registrarActividad(
            'vacaciones',
            'solicitar',
            'El trabajador ' . $trabajador->nombre . ' ' . $trabajador->apellido .
            ' solicitó vacaciones desde ' . $request->fecha_inicio .
            ' hasta ' . $request->fecha_fin .
            ' (' . $dias . ' días)'
        );

        return back()->with('success', 'Solicitud enviada correctamente');
    }

    public function indexAdmin()    // muestra listado de solicitudes de vacaciones de trabajadores para que el admin aprueba o rechazar
    {
        $empresaId = auth()->user()->empresa_id;

        $vacaciones = Vacacion::with('trabajador')
            ->whereHas('trabajador', function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->latest()
            ->get();

        return view('admin.vacaciones.index', compact('vacaciones'));
    }

    public function aprobar(Request $request, Vacacion $vacacion)    // el admin aprueba la solicitud de vacaciones
    {
        $vacacion->update([
            'estado' => 'aprobado',
            'comentario_admin' => $request->comentario_admin,
            'fecha_respuesta' => now()
        ]);

        $trabajador = $vacacion->trabajador;

        registrarActividad(
            'vacaciones',
            'aprobar',
            'Se aprobaron vacaciones de ' . $trabajador->nombre . ' ' . $trabajador->apellido .
            ' desde ' . $vacacion->fecha_inicio .
            ' hasta ' . $vacacion->fecha_fin .
            ' (' . $vacacion->dias_solicitados . ' días)'
        );

        return back()->with('success', 'Vacación aprobada correctamente');
    }

    public function rechazar(Request $request, Vacacion $vacacion)   // el admin rechaza la solicitud de vacaciones
    {
        $vacacion->update([
            'estado' => 'rechazado',
            'comentario_admin' => $request->comentario_admin,
            'fecha_respuesta' => now()
        ]);

        $trabajador = $vacacion->trabajador;

        registrarActividad(
            'vacaciones',
            'rechazar',
            'Se rechazaron vacaciones de ' . $trabajador->nombre . ' ' . $trabajador->apellido .
            ' desde ' . $vacacion->fecha_inicio .
            ' hasta ' . $vacacion->fecha_fin .
            ' (' . $vacacion->dias_solicitados . ' días). Motivo: ' . ($request->comentario_admin ?? 'Sin comentario')
        );

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