<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeUser extends Model
{
    protected $table = 'mensaje_user';

    protected $fillable = [
        'mensaje_id',
        'user_id',
        'leido',
        'fecha_lectura',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_lectura' => 'datetime',
    ];

    public function mensaje()
    {
        return $this->belongsTo(Mensaje::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}