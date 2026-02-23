<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'apellido',
        'rut',
        'cargo',
    ];
}
