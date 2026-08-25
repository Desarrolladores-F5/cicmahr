<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpresaExterna extends Model
{
    use HasFactory;

    // ======================================================
    // 📝 CAMPOS ASIGNABLES
    // ======================================================

    protected $fillable = [

        // Empresa cliente propietaria del expediente
        'empresa_id',

        // Datos de la empresa externa
        'razon_social',
        'rut_empresa',
        'nombre_fantasia',
        'actividad',

        // Representante legal
        'nombre_representante',
        'rut_representante',
        'profesion_representante',
        'estado_civil_representante',

        // Contacto
        'correo_empresa',
        'telefono_empresa',
        'correo_representante',
        'telefono_representante',
        'direccion',
        'ciudad',

        // Estado actual
        'estado',
    ];

    // ======================================================
    // 📄 DOCUMENTOS DE LA EMPRESA EXTERNA
    // ======================================================

    public function documentos(): HasMany
    {
        return $this->hasMany(EmpresaExternaDocumento::class);
    }


    // ======================================================
    // 🔗 RELACIONES
    // ======================================================

    /**
     * Empresa cliente propietaria de este expediente externo.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
    
}