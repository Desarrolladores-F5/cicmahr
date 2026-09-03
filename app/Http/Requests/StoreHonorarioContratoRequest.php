<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHonorarioContratoRequest extends FormRequest
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
            // 📑 DATOS DEL CONTRATO
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

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            // ======================================================
            // 🛑 EVITAR SUPERPOSICIÓN DE CONTRATOS
            // ======================================================

            $honorario = $this->route('honorario');

            // Si por alguna razón no existe el prestador en la ruta,
            // no continuamos con esta validación adicional.
            if (!$honorario) {
                return;
            }

            // Si las fechas básicas ya vienen incompletas,
            // dejamos que rules() se encargue de informar el error.
            if (!$this->filled('fecha_inicio') || !$this->filled('fecha_termino')) {
                return;
            }

            $existeSuperposicion = $honorario->contratos()
                ->where('fecha_inicio', '<=', $this->fecha_termino)
                ->where('fecha_termino', '>=', $this->fecha_inicio)
                ->exists();

            if ($existeSuperposicion) {
                $validator->errors()->add(
                    'fecha_inicio',
                    'Las fechas ingresadas se superponen con otro contrato registrado para este prestador.'
                );
            }
        });
    }
}