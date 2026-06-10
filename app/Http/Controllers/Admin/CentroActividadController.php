<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MensajeUser;
use App\Models\Vacacion;
use App\Models\ReglamentoEntrega;
use App\Models\HoraExtra;
use Illuminate\Pagination\LengthAwarePaginator;

class CentroActividadController extends Controller
{
    public function index()
    {
        $empresa = Auth::user()->empresa;

        $actividadesMensajes = MensajeUser::with([
                'user',
                'mensaje',
            ])
            ->where('leido', true)
            ->whereNotNull('fecha_lectura')
            ->whereHas('mensaje', function ($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })
            ->get()
            ->map(function ($actividad) {
                return [
                    'tipo' => 'mensaje',
                    'icono' => '📩',
                    'titulo' => ($actividad->user->name ?? 'Trabajador') . ' leyó el mensaje "' . ($actividad->mensaje->titulo ?? 'Sin título') . '"',
                    'detalle' => 'Mensaje interno leído por el trabajador.',
                    'fecha' => $actividad->fecha_lectura,
                    'badge' => 'Leído',
                    'badge_class' => 'bg-green-100 text-green-700',
                    'icon_class' => 'bg-blue-100',
                ];
            });

        $actividadesVacaciones = Vacacion::with('trabajador')
            ->whereHas('trabajador', function ($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })
            ->get()
            ->map(function ($vacacion) {
                $nombreTrabajador = trim(
                    ($vacacion->trabajador->nombre ?? '') . ' ' .
                    ($vacacion->trabajador->apellido ?? '')
                );

                return [
                    'tipo' => 'vacacion',
                    'icono' => '🏖️',
                    'titulo' => ($nombreTrabajador ?: 'Trabajador') . ' solicitó vacaciones',
                    'detalle' => 'Desde ' . $vacacion->fecha_inicio . ' hasta ' . $vacacion->fecha_fin . ' · ' . $vacacion->dias_solicitados . ' día(s).',
                    'fecha' => $vacacion->created_at,
                    'badge' => ucfirst($vacacion->estado),
                    'badge_class' => match ($vacacion->estado) {
                        'aprobada' => 'bg-green-100 text-green-700',
                        'rechazada' => 'bg-red-100 text-red-700',
                        default => 'bg-yellow-100 text-yellow-700',
                    },
                    'icon_class' => 'bg-emerald-100',
                ];
            });

        $actividadesReglamentos = ReglamentoEntrega::with([
                'trabajador',
                'reglamento',
            ])
            ->where('leido', true)
            ->whereNotNull('fecha_lectura')
            ->whereHas('reglamento', function ($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })
            ->get()
            ->map(function ($entrega) {
                $nombreTrabajador = trim(
                    ($entrega->trabajador->nombre ?? '') . ' ' .
                    ($entrega->trabajador->apellido ?? '')
                );

                return [
                    'tipo' => 'reglamento',
                    'icono' => '📄',
                    'titulo' => ($nombreTrabajador ?: 'Trabajador') . ' aceptó un reglamento',
                    'detalle' => '"' . ($entrega->reglamento->nombre ?? 'Reglamento') . '" · Año ' . ($entrega->reglamento->anio ?? 'N/A'),
                    'fecha' => $entrega->fecha_lectura,
                    'badge' => 'Aceptado',
                    'badge_class' => 'bg-blue-100 text-blue-700',
                    'icon_class' => 'bg-indigo-100',
                ];
            });


        $actividadesHorasExtras = HoraExtra::with('trabajador')
            ->whereHas('trabajador', function ($query) use ($empresa) {
                $query->where('empresa_id', $empresa->id);
            })
            ->get()
            ->map(function ($horaExtra) {
                $nombreTrabajador = trim(
                    ($horaExtra->trabajador->nombre ?? '') . ' ' .
                    ($horaExtra->trabajador->apellido ?? '')
                );

                return [
                    'tipo' => 'hora_extra',
                    'icono' => '⏰',
                    'titulo' => ($nombreTrabajador ?: 'Trabajador') . ' registró horas extras',
                    'detalle' => $horaExtra->horas . ' hora(s) · Fecha trabajada: ' . $horaExtra->fecha,
                    'fecha' => $horaExtra->created_at,
                    'badge' => ucfirst($horaExtra->estado),
                    'badge_class' => match ($horaExtra->estado) {
                        'aprobada' => 'bg-green-100 text-green-700',
                        'rechazada' => 'bg-red-100 text-red-700',
                        default => 'bg-orange-100 text-orange-700',
                    },
                    'icon_class' => 'bg-orange-100',
                ];
            });

        $actividades = collect()
            ->concat($actividadesMensajes)
            ->concat($actividadesVacaciones)
            ->concat($actividadesReglamentos)
            ->concat($actividadesHorasExtras)
            ->sortByDesc('fecha')
            ->values();

        $paginaActual = request()->get('page', 1);

            $porPagina = 10;

            $actividades = new LengthAwarePaginator(
                $actividades->forPage($paginaActual, $porPagina),
                $actividades->count(),
                $porPagina,
                $paginaActual,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );

        return view('admin.actividad.index', compact('actividades'));
    }
}