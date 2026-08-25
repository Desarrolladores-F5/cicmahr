<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaExternaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $empresaExterna = $this->route('empresaExterna');

        return $this->user()
            && $empresaExterna
            && $empresaExterna->empresa_id === $this->user()->empresa_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $empresaExterna = $this->route('empresaExterna');

        return [

            // ======================================================
            // 🏢 INFORMACIÓN GENERAL
            // ======================================================

            'razon_social' => [
                'required',
                'string',
                'max:255',
            ],

            'nombre_fantasia' => [
                'nullable',
                'string',
                'max:255',
            ],

            'rut_empresa' => [
                'required',
                'string',
                'max:20',

                Rule::unique('empresa_externas', 'rut_empresa')
                    ->ignore($empresaExterna->id),
            ],

            'actividad' => [
                'required',
                'string',
                'max:255',
            ],


            // ======================================================
            // 👤 REPRESENTANTE LEGAL
            // ======================================================

            'nombre_representante' => [
                'required',
                'string',
                'max:255',
            ],

            'rut_representante' => [
                'required',
                'string',
                'max:20',
            ],

            'profesion_representante' => [
                'nullable',
                'string',
                'max:255',
            ],

            'estado_civil_representante' => [
                'nullable',
                Rule::in([
                    'soltero',
                    'casado',
                    'divorciado',
                    'viudo',
                ]),
            ],


            // ======================================================
            // 📞 CONTACTO Y UBICACIÓN
            // ======================================================

            'correo_empresa' => [
                'nullable',
                'email',
                'max:255',
            ],

            'telefono_empresa' => [
                'nullable',
                'string',
                'max:30',
            ],

            'correo_representante' => [
                'nullable',
                'email',
                'max:255',
            ],

            'telefono_representante' => [
                'nullable',
                'string',
                'max:30',
            ],

            'direccion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ciudad' => [
                'nullable',
                'string',
                'max:255',
            ],


            // ======================================================
            // ⚙️ ESTADO
            // ======================================================

            'estado' => [
                'required',
                Rule::in([
                    'activo',
                    'inactivo',
                ]),
            ],

        ];
    }
}