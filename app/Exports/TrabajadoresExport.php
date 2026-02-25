<?php

namespace App\Exports;

use App\Models\Trabajador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrabajadoresExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $empresaId = auth()->user()->empresa_id;

        return Trabajador::where('empresa_id', $empresaId)
            ->select([
                'rut',
                'nombre',
                'apellido',
                'direccion',
                'cargo',
                'sueldo',
                'tipo_contrato',
                'fecha_ingreso',
                'fecha_salida',
                'estado',
                'horario',
            ])
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();
    }

    public function headings(): array
    {
        return [
            'RUT',
            'Nombre',
            'Apellido',
            'Dirección',
            'Cargo',
            'Sueldo',
            'Tipo de contrato',
            'Fecha ingreso',
            'Fecha salida',
            'Estado',
            'Horario',
        ];
    }
}