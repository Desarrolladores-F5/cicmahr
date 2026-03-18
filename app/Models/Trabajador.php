<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trabajador extends Model        // Modelo para la tabla trabajadores
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

    public function documentos()          // Relación con documentos conecta con el modelo Documento
    {
        return $this->hasMany(\App\Models\Documento::class);
    }

    public function user()       // Relación con User conecta con el modelo User
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function horasExtras()             // Relación con horas extras conecta con el modelo HoraExtra
    {
        return $this->hasMany(HoraExtra::class);
    }

    public function vacaciones()    // Relación con vacaciones conecta con el modelo Vacacion
    {
        return $this->hasMany(Vacacion::class);
    }
}
