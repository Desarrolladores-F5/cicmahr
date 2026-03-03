<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(403, 'No autenticado.');
        }

        if (auth()->user()->rol !== $role) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}