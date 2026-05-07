<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTrial
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !$user->empresa) {
            return $next($request);
        }

        $empresa = $user->empresa;

        // Si la empresa ya pagó, entra siempre.
        if ($empresa->suscripcion_activa) {
            return $next($request);
        }

        // Evita loop con rutas permitidas.
        if ($request->routeIs('trial.expirado') || $request->routeIs('activar.cuenta') || $request->routeIs('webpay.*') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Si NO tiene suscripción y el trial terminó, bloquear.
        if (!$empresa->enTrial()) {
            return redirect()->route('trial.expirado', request()->query());
        }

        return $next($request);
    }
}