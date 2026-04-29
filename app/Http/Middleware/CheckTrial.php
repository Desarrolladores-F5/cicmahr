<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTrial
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Si no hay usuario o empresa, deja pasar (otros middlewares se encargan)
        if (!$user || !$user->empresa) {
            return $next($request);
        }

        // Permitir siempre estas rutas (evita loops)
        if ($request->routeIs('trial.expirado') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Si NO está en trial → bloquear
        if (!$user->empresa->enTrial()) {
            return redirect()->route('trial.expirado');
        }

        return $next($request);
    }
}