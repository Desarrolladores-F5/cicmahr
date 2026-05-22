<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
            'trial' => \App\Http\Middleware\CheckTrial::class, // 👈 se agrega para el trial
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class, // 👈 se agrega para el superadmin
            'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class, // 👈 se agrega para prevenir el historial después de cerrar sesión
            'empresa.status' => \App\Http\Middleware\CheckEmpresaStatus::class,   // 👈 se agrega para verificar el estado de la empresa (activa, suspendida, etc.)
        ]);

    })
    
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
