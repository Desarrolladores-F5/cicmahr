<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaExternaDocumento extends Model
{
    // ======================================================
    // 📄 CAMPOS ASIGNABLES
    // ======================================================

    protected $fillable = [
        'empresa_externa_id',
        'nombre_documento',
        'tipo_documento',
        'archivo',
        'fecha_emision',
        'fecha_vencimiento',
        'observaciones',
    ];

    // ======================================================
    // 📅 CONVERSIÓN DE TIPOS
    // ======================================================

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    // ======================================================
    // 🏢 RELACIÓN CON EMPRESA EXTERNA
    // ======================================================

    public function empresaExterna(): BelongsTo
    {
        return $this->belongsTo(EmpresaExterna::class);
    }
}