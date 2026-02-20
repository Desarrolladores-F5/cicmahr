<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    protected $fillable = [
        'nombre',
        'rut',
        'giro',
        'direccion',
        'plan',
        'estado',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function trabajadores(): HasMany
    {
        return $this->hasMany(Trabajador::class);
    }
}



