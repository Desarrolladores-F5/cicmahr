<?php

namespace App\Http\Controllers;

use App\Models\HoraExtra;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use App\Exports\HorasExtrasMesExport;
use Maatwebsite\Excel\Facades\Excel;

class HoraExtraController extends Controller
{
    public function trabajadores()   // Muestra listado de trabajadores para gestionar horas extras
    {
        $empresaId = auth()->user()->empresa_id;

        $trabajadores = \App\Models\Trabajador::where('empresa_id', $empresaId)
            ->withSum(['horasExtras as horas_mes_actual' => function ($query) {
                $query->where('estado', 'aprobado')
                    ->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year);
            }], 'horas')
            ->orderByDesc('horas_mes_actual')
            ->orderBy('nombre')
            ->get();

            // 🔥 Total horas extras de toda la empresa en el mes
            $totalHorasEmpresaMes = \App\Models\HoraExtra::whereHas('trabajador', function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
                })
                ->where('estado', 'aprobado')
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->sum('horas');

            // 🔥 Cálculo del costo estimado total
            $costoTotalEstimado = 0;

            foreach ($trabajadores as $trabajador) {

                $horasSemanales = 40;
                $horasDiarias = $horasSemanales / 5;

                $valorHora = $trabajador->sueldo / 30 / $horasDiarias;
                $valorHoraExtra = $valorHora * 1.5;

                $horasTrabajador = $trabajador->horas_mes_actual ?? 0;

                $costoTotalEstimado += $valorHoraExtra * $horasTrabajador;
            }

            // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
            registrarActividad(
                'horas_extras',
                'visita',
                'Se visualizó el listado de trabajadores con horas extras'
            );


        return view('admin.horas_extras.trabajadores', compact('trabajadores', 'totalHorasEmpresaMes', 'costoTotalEstimado'));
    }

    public function index(Trabajador $trabajador)  //Muestra las horas extras de un trabajador específico y total del mes actual.
    {
        // Seguridad: que el admin solo vea trabajadores de su empresa
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $horasExtras = $trabajador->horasExtras()
            ->latest('fecha')
            ->get();

        $totalMesActual = $trabajador->horasExtras()
            ->where('estado', 'aprobado')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('horas');

        $horasSemanales = $trabajador->empresa->horas_semanales ?? 40;    // 🔥 Asumimos jornada semanal de 40 horas

        $horasDiarias = $horasSemanales / 5;   // 🔥 Calculamos horas diarias a partir de las horas semanales (40hrs/5 días)

        $valorHora = round($trabajador->sueldo / 30 / $horasDiarias);   // 🔥 Valor hora normal

        // 🔥 Hora extra con recargo
        $valorHoraExtra = round($valorHora * 1.5);

        // 🔥 Monto total horas extras
        $montoHorasExtras = round($valorHoraExtra * $totalMesActual);

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'horas_extras',
            'visita',
            'Se visualizaron las horas extras de ' . $trabajador->nombre . ' ' . $trabajador->apellido
        );

        return view('admin.horas_extras.index', compact(
            'trabajador',
            'horasExtras',
            'totalMesActual',
            'valorHora',
            'valorHoraExtra',
            'montoHorasExtras'

            ));
        }

    public function store(Request $request, Trabajador $trabajador)    //Permite que el admin registre una hora extra nueva.
    {
        // Seguridad: que el admin solo registre horas a trabajadores de su empresa
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $request->validate([
            'fecha' => 'required|date',
            'horas' => 'required|numeric|min:0.5|max:2',          // Validamos que las horas extras sean entre 0.5 (media hora) y 2hrs max.
            'motivo' => 'nullable|string|max:255',
        ]);

        HoraExtra::create([
            'trabajador_id' => $trabajador->id,
            'fecha' => $request->fecha,
            'horas' => $request->horas,
            'motivo' => $request->motivo,
            'estado' => 'pendiente',   // Las horas extras se registran como "pendiente" para que el admin las revise y apruebe.
            'registrado_por' => auth()->id(),
        ]);

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'horas_extras',
            'crear',
            'Se registraron ' . $request->horas . ' hrs extra para ' .
            $trabajador->nombre . ' ' . $trabajador->apellido .
            ' el día ' . $request->fecha .
            ($request->motivo ? ' (Motivo: ' . $request->motivo . ')' : '')
        );

        return back()->with('success', 'Horas extras registradas correctamente.');
    }

    public function exportExcel()      // Permite que el admin exporte un excel con las horas extras del mes actual de todos los trabajadores.
    {
        return Excel::download(
            new HorasExtrasMesExport,
            'horas_extras_mes_actual.xlsx'
        );
    }
}