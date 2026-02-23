<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si no está logueado, fuera (aunque normalmente auth middleware ya lo cubre)
        if (!$user) {
            abort(401, 'No autenticado.');
        }

        // Solo admins pueden pasar
        if (!in_array($user->rol, ['admin_primario', 'admin_secundario'])) {
            abort(403, 'No autorizado.');
        }

        return $next($request);
    }
}