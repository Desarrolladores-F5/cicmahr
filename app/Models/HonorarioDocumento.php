<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HonorarioDocumento extends Model
{
    // ======================================================
    // 📄 CAMPOS ASIGNABLES
    // ======================================================

    protected $fillable = [
        'honorario_id',
        'tipo',
        'nombre_original',
        'ruta_archivo',
    ];

    // ======================================================
    // 👤 RELACIÓN CON PRESTADOR A HONORARIOS
    // ======================================================

    public function honorario(): BelongsTo
    {
        return $this->belongsTo(Honorario::class);
    }
}