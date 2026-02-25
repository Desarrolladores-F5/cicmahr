<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Contrato',
            'Contrato a Honorarios',
            'Ampliación de contrato',
            'Anexo de contrato',
            'Contrato indefinido',
            'Cambio de domicilio',
            'Finiquito',            
            'Licencia médica',
            'Liquidación de sueldo',
            'Suspensión de contrato',
            'Otros documentos',     
            'Vacaciones',
        ];

        foreach ($tipos as $t) {
            DB::table('tipos_documento')->updateOrInsert(
                ['nombre_documento' => $t],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}