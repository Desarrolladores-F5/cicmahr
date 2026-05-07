<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'empresa_id',
        'orden',
        'monto',
        'estado',
        'fecha_pago',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}