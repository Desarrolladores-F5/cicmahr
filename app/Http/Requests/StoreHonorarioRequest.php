<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHonorarioRequest extends FormRequest
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
            // 👤 DATOS DEL PRESTADOR
            // ======================================================

            'nombre' => [
                'required',
                'string',
                'max:100',
            ],

            'apellido' => [
                'required',
                'string',
                'max:100',
            ],

            'rut' => [
                'required',
                'string',
                'max:20',
            ],

            'profesion_oficio' => [
                'required',
                'string',
                'max:150',
            ],

            'direccion' => [
                'required',
                'string',
                'max:255',
            ],

            'correo' => [
                'required',
                'email',
                'max:255',
            ],

            'telefono' => [
                'required',
                'string',
                'max:30',
            ],

            // ======================================================
            // 📑 PRIMER CONTRATO
            // ======================================================

            'cargo' => [
                'required',
                'string',
                'max:150',
            ],

            'monto_honorario' => [
                'required',
                'integer',
                'min:0',
            ],

            'fecha_inicio' => [
                'required',
                'date',
            ],

            'fecha_termino' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio',
            ],

            // ======================================================
            // 🕒 JORNADA
            // ======================================================

            'hora_inicio' => [
                'required',
                'date_format:H:i',
            ],

            'hora_termino' => [
                'required',
                'date_format:H:i',
                'after:hora_inicio',
            ],

            'horas_semanales' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}