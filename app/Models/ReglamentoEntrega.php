<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReglamentoEntrega extends Model
{
    protected $fillable = [
        'reglamento_id',
        'trabajador_id',
        'leido',
        'fecha_lectura',
        'ip',
        'user_agent',
    ];

    public function reglamento()
    {
        return $this->belongsTo(Reglamento::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}