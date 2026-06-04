<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'empresa_id',
        'remitente_id',
        'titulo',
        'mensaje',
        'para_todos',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    public function destinatarios()
    {
        return $this->hasMany(MensajeUser::class);
    }
}