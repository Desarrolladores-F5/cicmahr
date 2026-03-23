<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reglamento extends Model
{
    protected $fillable = [
        'empresa_id',
        'nombre',
        'anio',
        'archivo',
        'descripcion',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}