<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHonorarioContratoArchivoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado
     * para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el contrato firmado.
     */
    public function rules(): array
    {
        return [
            'archivo' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'archivo.required' => 'Debes seleccionar el contrato firmado.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'El contrato firmado debe ser un archivo PDF.',
            'archivo.max' => 'El contrato firmado no puede superar los 10 MB.',
        ];
    }
}