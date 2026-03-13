<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoraExtra extends Model
{
    protected $table = 'horas_extras';

    protected $fillable = [
        'trabajador_id',
        'fecha',
        'horas',
        'motivo',
        'estado',
        'registrado_por'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}