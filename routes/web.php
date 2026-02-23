<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajadorController;

Route::get('/', function () {
    return view('welcome');
});

//por si alguien intenta acceder a la ruta de registro, lo redirigimos al login, ya que no se permite el registro de nuevos usuarios
Route::redirect('/register', '/login');    

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (in_array($user->rol, ['admin_primario', 'admin_secundario'])) {
        return redirect('/admin');
    }

    if ($user->rol === 'trabajador') {
        return redirect('/worker');
    }

    return redirect('/');

})->middleware(['auth'])->name('dashboard');

// Dashboard Admin - áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        $empresa = auth()->user()->empresa;
        $totalTrabajadores = $empresa->trabajadores()->count();
        $limite = $empresa->limiteTrabajadores();

        return view('admin.dashboard', compact(
            'empresa',
            'totalTrabajadores',
            'limite'
        ));

})->name('admin.dashboard');

    Route::get('/trabajadores', [TrabajadorController::class, 'index'])
        ->name('trabajadores.index');

    Route::get('/trabajadores/create', [TrabajadorController::class, 'create'])
        ->name('trabajadores.create');

    Route::post('/trabajadores', [TrabajadorController::class, 'store'])
        ->name('trabajadores.store');
});

// áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de trabajador
Route::middleware('auth')->group(function () {
    Route::get('/worker', function () {
        return view('worker.dashboard');
    })->name('worker.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
