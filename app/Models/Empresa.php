<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trabajador;

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

    public function users(): HasMany      // Esta función define la relación entre Empresa y User, indicando que una empresa puede tener muchos usuarios
    {
        return $this->hasMany(User::class);
    }

    public function trabajadores(): HasMany             // Esta función define la relación entre Empresa y Trabajador, indicando que una empresa puede tener muchos trabajadores
    {
        return $this->hasMany(Trabajador::class);
    }

    public function limiteTrabajadores(): int          // En esta función definimos el límite de trabajadores según el plan
    {
        return match ($this->plan) {
            'basico' => 20,
            'pyme' => 50,
            'pro' => 9999,
            default => 0,
        };
    }

    public function puedeAgregarTrabajador(): bool   // Esta función verifica si se puede agregar un nuevo trabajador según el límite del plan
    {
        return $this->trabajadores()->count() < $this->limiteTrabajadores();
    }
}



