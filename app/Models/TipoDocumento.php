<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento'; // ✅ IMPORTANTE

    protected $fillable = ['nombre_documento'];

    // Opcional: para usar $tipo->nombre en vez de $tipo->nombre_documento
    public function getNombreAttribute()
    {
        return $this->nombre_documento;
    }
}