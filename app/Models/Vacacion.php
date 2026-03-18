<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    protected $table = 'vacaciones';

    protected $fillable = [
        'trabajador_id',
        'fecha_inicio',
        'fecha_fin',
        'dias_solicitados',
        'estado',
        'comentario_trabajador',
        'comentario_admin',
        'fecha_respuesta'
    ];

    // Relación: pertenece a un trabajador
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}