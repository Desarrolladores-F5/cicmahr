<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadUsuario extends Model
{
    protected $table = 'actividad_usuario';

    protected $fillable = [
        'user_id',
        'modulo',
        'accion',
        'descripcion',
        'ip',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}