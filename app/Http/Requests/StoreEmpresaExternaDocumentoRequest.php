<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaExternaDocumentoRequest extends FormRequest
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
     * Reglas de validación para subir
     * un documento de empresa externa.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            // ======================================================
            // 📄 INFORMACIÓN DEL DOCUMENTO
            // ======================================================

            'nombre_documento' => [
                'required',
                'string',
                'max:255',
            ],

            'tipo_documento' => [
                'required',
                'string',
                'in:legal,tributario,laboral,certificado,antecedente,otro',
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

            // ======================================================
            // 📝 OBSERVACIONES
            // ======================================================

            'observaciones' => [
                'nullable',
                'string',
                'max:2000',
            ],

        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [

            'nombre_documento.required' =>
                'Debes ingresar el nombre del documento.',

            'nombre_documento.max' =>
                'El nombre del documento no puede superar los 255 caracteres.',

            'tipo_documento.required' =>
                'Debes seleccionar el tipo de documento.',

            'tipo_documento.in' =>
                'El tipo de documento seleccionado no es válido.',

            'archivo.required' =>
                'Debes seleccionar un archivo.',

            'archivo.file' =>
                'El archivo seleccionado no es válido.',

            'archivo.mimes' =>
                'El documento debe ser un archivo PDF, JPG, JPEG o PNG.',

            'archivo.max' =>
                'El archivo no puede superar los 10 MB.',

            'observaciones.max' =>
                'Las observaciones no pueden superar los 2000 caracteres.',

        ];
    }
}