<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HonorarioContrato extends Model
{
    // ======================================================
    // 📑 CAMPOS ASIGNABLES
    // ======================================================

    protected $fillable = [
        'honorario_id',
        'cargo',
        'monto_honorario',
        'fecha_inicio',
        'fecha_termino',
        'hora_inicio',
        'hora_termino',
        'horas_semanales',
        'nombre_archivo_contrato',
        'ruta_archivo_contrato',
    ];

    // ======================================================
    // 🔄 CONVERSIÓN DE TIPOS
    // ======================================================

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
        'monto_honorario' => 'integer',
        'horas_semanales' => 'integer',
    ];

    // ======================================================
    // 👤 RELACIÓN CON PRESTADOR A HONORARIOS
    // ======================================================

    public function honorario(): BelongsTo
    {
        return $this->belongsTo(Honorario::class);
    }

    // ======================================================
    // 🚦 ESTADO AUTOMÁTICO DEL CONTRATO
    // ======================================================

    protected function estado(): Attribute
    {
        return Attribute::make(
            get: function () {

                $hoy = now()->startOfDay();

                if ($hoy->lt($this->fecha_inicio)) {
                    return 'proximo';
                }

                if ($hoy->gt($this->fecha_termino)) {
                    return 'finalizado';
                }

                return 'vigente';
            }
        );
    }
}