<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHonorarioDocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            // ======================================================
            // 🏷️ TIPO DE DOCUMENTO
            // ======================================================

            'tipo' => [
                'required',
                'string',
                'max:100',
            ],

            // ======================================================
            // 📎 ARCHIVO
            // ======================================================

            'archivo' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
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

            'tipo.required' => 'Debes seleccionar el tipo de documento.',

            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'El documento debe ser un archivo PDF, JPG, JPEG o PNG.',
            'archivo.max' => 'El documento no puede superar los 10 MB.',
        ];
    }
}