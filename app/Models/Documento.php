<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'trabajador_id',
        'tipo_documento_id',
        'ruta_archivo',
        'fecha_documento',
        'observaciones',
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
}