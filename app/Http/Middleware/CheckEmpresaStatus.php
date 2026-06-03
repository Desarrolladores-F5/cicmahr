<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmpresaStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si no hay usuario logueado, continuar
        if (!$user) {
            return $next($request);
        }

        // SuperAdmin no debe ser afectado
        if ($user->rol === 'superadmin') {
            return $next($request);
        }

        // Si el usuario no pertenece a empresa, continuar
        if (!$user->empresa) {
            return $next($request);
        }

        $empresa = $user->empresa;

        // 🚨 Trial expirado
        if (
            $empresa->trial_hasta &&
            now()->greaterThan($empresa->trial_hasta) &&
            $empresa->estado === 'activa'
        ) {

            // Suspender automáticamente
            $empresa->update([
                'estado' => 'suspendida'
            ]);

            // Registrar auditoría
            registrarActividad(
                'billing',
                'suspension_automatica',
                'Empresa suspendida automáticamente por trial expirado: '
                . $empresa->nombre
            );
        }

        // 🚨 Suscripción vencida
        if (
            $empresa->suscripcion_hasta &&
            now()->greaterThan($empresa->suscripcion_hasta) &&
            $empresa->estado === 'activa'
        ) {

            // Suspender automáticamente por suscripción vencida
            $empresa->update([
                'estado' => 'suspendida',
                'suscripcion_activa' => false,
            ]);

            // Registrar auditoría
            registrarActividad(
                'billing',
                'suscripcion_vencida',
                'Empresa suspendida automáticamente por suscripción vencida: '
                . $empresa->nombre
            );
        }

        // 🚨 Empresa suspendida
        if ($empresa->estado === 'suspendida') {

            auth()->logout();

            return redirect()->route('planes.index');
        }

        return $next($request);
    }
}