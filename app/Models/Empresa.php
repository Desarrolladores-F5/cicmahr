<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Trabajador;
use App\Models\Pago;

class Empresa extends Model
{
    protected $fillable = [
        'nombre',
        'rut',
        'giro',
        'direccion',
        'plan',
        'estado',
        'trial_hasta',
        'suscripcion_activa',
        'suscripcion_hasta',
    ];

    protected $casts = [
        'trial_hasta' => 'datetime',
        'suscripcion_hasta' => 'datetime',
        'suscripcion_activa' => 'boolean',
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

    public function limiteAdministradores(): int  // En esta función definimos el límite de administradores según el plan
    {
        return match ($this->plan) {
            'basico' => 5,
            'pyme' => 10,      // puedes ajustar
            'pro' => 9999,
            default => 0,
        };
    }

    public function puedeAgregarAdministrador(): bool  // Esta función verifica si se puede agregar un nuevo administrador según el límite del plan
    {
        // admins = admin_primario + admin_secundario
        $adminsActuales = $this->users()
            ->whereIn('rol', ['admin_primario', 'admin_secundario'])
            ->count();

        return $adminsActuales < $this->limiteAdministradores();
    }

    public function reglamentos()         // Esta función se encarga del Reglamento de cada empresa, y cada empresa puede tener muchos reglamentos, por eso se usa hasMany
    {
        return $this->hasMany(Reglamento::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function enTrial(): bool     // Esta función verifica si la empresa está o no en período de prueba.
    {
        return $this->trial_hasta && now()->lessThanOrEqualTo($this->trial_hasta);
    }

    public function diasRestantesTrial(): int    // Esta función calcula los días restantes del período de prueba, si no hay fecha de trial_hasta, devuelve 0.
    {
        if (!$this->trial_hasta) return 0;

        return max(0, now()->diffInDays($this->trial_hasta));
    }
}



