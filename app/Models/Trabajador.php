<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = [
        'empresa_id',
        'rut',
        'nombre',
        'apellido',
        'direccion',
        'email_contacto',
        'cargo',
        'sueldo',
        'tipo_contrato',
        'fecha_ingreso',
        'fecha_salida',
        'estado',
        'horario',
        'fecha_registro',
        'user_id', // 👈 CLAVE
    ];

    public function documentos()
    {
        return $this->hasMany(\App\Models\Documento::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function horasExtras()             // Relación con horas extras
    {
        return $this->hasMany(HoraExtra::class);
    }
}
