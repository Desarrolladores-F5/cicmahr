<?php

use App\Models\ActividadUsuario;

if (!function_exists('registrarActividad')) {

    function registrarActividad($modulo, $accion, $descripcion = null)
    {
        try {
            $user = auth()->user();

            ActividadUsuario::create([
                'user_id' => $user ? $user->id : null,
                'modulo' => $modulo,
                'accion' => $accion,
                'descripcion' => $descripcion,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

        } catch (\Exception $e) {
            // Evitamos que un error de log rompa la app
            \Log::error('Error registrando actividad: ' . $e->getMessage());
        }
    }
}