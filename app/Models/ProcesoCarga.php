<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoCarga extends Model
{
    protected $table = 'procesos_carga';

    protected $fillable = [
        'empresa_id',
        'total_archivos',
        'procesados',
        'asignados',
        'no_encontrados',
        'estado'
    ];
}