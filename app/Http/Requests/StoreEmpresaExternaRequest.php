<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmpresaExternaRequest extends FormRequest
{
    // ======================================================
    // 🔐 AUTORIZACIÓN
    // ======================================================

    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->empresa_id !== null;
    }

    // ======================================================
    // ✅ REGLAS DE VALIDACIÓN
    // ======================================================

    public function rules(): array
    {
        $empresaId = auth()->user()->empresa_id;

        return [

            // ======================================================
            // 🏢 DATOS DE LA EMPRESA EXTERNA
            // ======================================================

            'razon_social' => [
                'required',
                'string',
                'max:255',
            ],

            'rut_empresa' => [
                'required',
                'string',
                'max:20',

                Rule::unique('empresa_externas', 'rut_empresa')
                    ->where(
                        fn ($query) => $query->where('empresa_id', $empresaId)
                    ),
            ],

            'nombre_fantasia' => [
                'nullable',
                'string',
                'max:255',
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
                    'conviviente_civil',
                    'separado',
                ]),
            ],

            // ======================================================
            // 📍 CONTACTO
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
                    'finalizado',
                    'suspendido',
                ]),
            ],
        ];
    }

    // ======================================================
    // 💬 MENSAJES PERSONALIZADOS
    // ======================================================

    public function messages(): array
    {
        return [
            'razon_social.required' =>
                'La razón social de la empresa externa es obligatoria.',

            'rut_empresa.required' =>
                'El RUT de la empresa externa es obligatorio.',

            'rut_empresa.unique' =>
                'Esta empresa externa ya se encuentra registrada en tu empresa.',

            'actividad.required' =>
                'La actividad de la empresa externa es obligatoria.',

            'nombre_representante.required' =>
                'El nombre del representante legal es obligatorio.',

            'rut_representante.required' =>
                'El RUT del representante legal es obligatorio.',

            'estado_civil_representante.in' =>
                'El estado civil seleccionado no es válido.',

            'correo_empresa.email' =>
                'El correo de la empresa debe tener un formato válido.',

            'correo_representante.email' =>
                'El correo del representante debe tener un formato válido.',

            'estado.required' =>
                'El estado de la empresa externa es obligatorio.',

            'estado.in' =>
                'El estado seleccionado no es válido.',
        ];
    }

    // ======================================================
    // 🏷️ NOMBRES AMIGABLES DE LOS CAMPOS
    // ======================================================

    public function attributes(): array
    {
        return [
            'razon_social' => 'razón social',
            'rut_empresa' => 'RUT de la empresa',
            'nombre_fantasia' => 'nombre de fantasía',
            'actividad' => 'actividad de la empresa',
            'nombre_representante' => 'nombre del representante legal',
            'rut_representante' => 'RUT del representante legal',
            'profesion_representante' => 'profesión del representante legal',
            'estado_civil_representante' => 'estado civil del representante legal',
            'correo_empresa' => 'correo de la empresa',
            'telefono_empresa' => 'teléfono de la empresa',
            'correo_representante' => 'correo del representante legal',
            'telefono_representante' => 'teléfono del representante legal',
            'direccion' => 'dirección',
            'ciudad' => 'ciudad',
            'estado' => 'estado',
        ];
    }
}