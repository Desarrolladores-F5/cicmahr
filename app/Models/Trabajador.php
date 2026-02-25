<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = [
        'empresa_id',
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
        'fecha_registro',
    ];

    public function documentos()
    {
        return $this->hasMany(\App\Models\Documento::class);
    }
}
