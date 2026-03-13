<?php

namespace App\Exports;

use App\Models\HoraExtra;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HorasExtrasMesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $empresaId = Auth::user()->empresa_id;

        return HoraExtra::with('trabajador')
            ->whereHas('trabajador', function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->where('estado', 'aprobado')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->get()
            ->map(function ($horaExtra) {

                $trabajador = $horaExtra->trabajador;

                $horasSemanales = 40;
                $horasDiarias = $horasSemanales / 5;

                $valorHora = $trabajador->sueldo / 30 / $horasDiarias;
                $valorHoraExtra = $valorHora * 1.5;

                $total = $valorHoraExtra * $horaExtra->horas;

                return [
                    'Trabajador' => $trabajador->nombre,
                    'RUT' => $trabajador->rut,
                    'Fecha' => $horaExtra->fecha,
                    'Horas extras' => $horaExtra->horas,
                    'Valor hora extra' => round($valorHoraExtra),
                    'Total estimado' => round($total),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Trabajador',
            'RUT',
            'Fecha',
            'Horas extras',
            'Valor hora extra',
            'Total estimado'
        ];
    }
}