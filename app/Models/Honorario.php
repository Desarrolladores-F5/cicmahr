<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Honorario extends Model
{
    // ======================================================
    // 👤 CAMPOS ASIGNABLES
    // ======================================================

    protected $fillable = [

        // Empresa propietaria del expediente
        'empresa_id',

        // Datos personales
        'nombre',
        'apellido',
        'rut',
        'profesion_oficio',
        'direccion',
        'correo',
        'telefono',
    ];

    // ======================================================
    // 🏢 RELACIÓN CON EMPRESA
    // ======================================================

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    // ======================================================
    // 📑 HISTORIAL DE CONTRATOS
    // ======================================================

    public function contratos(): HasMany
    {
        return $this->hasMany(HonorarioContrato::class);
    }

    // ======================================================
    // 📁 DOCUMENTOS PERSONALES DEL PRESTADOR
    // ======================================================

    public function documentos(): HasMany
    {
        return $this->hasMany(HonorarioDocumento::class);
    }

    // ======================================================
    // 🚦 ESTADO AUTOMÁTICO DEL PRESTADOR
    // ======================================================

    protected function estado(): Attribute
    {
        return Attribute::make(
            get: function () {

                $hoy = now()->toDateString();

                $tieneContratoVigente = $this->contratos()
                    ->whereDate('fecha_inicio', '<=', $hoy)
                    ->whereDate('fecha_termino', '>=', $hoy)
                    ->exists();

                return $tieneContratoVigente
                    ? 'activo'
                    : 'inactivo';
            }
        );
    }
}