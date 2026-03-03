<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\DocumentoController;
use App\Exports\TrabajadoresExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Worker\WorkerController;


Route::get('/', function () {
    return view('welcome');
});

//por si alguien intenta acceder a la ruta de registro, lo redirigimos al login, ya que no se permite el registro de nuevos usuarios
Route::redirect('/register', '/login');    

Route::get('/dashboard', function () {     //redireccionamos al dashboard correspondiente según el rol del usuario
    $user = auth()->user();

    if (in_array($user->rol, ['admin_primario', 'admin_secundario'])) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->rol === 'trabajador') {
        return redirect()->route('worker.dashboard');
    }

    return redirect('/');

})->middleware(['auth'])->name('dashboard');

// Dashboard Admin - áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {

        $empresa = auth()->user()->empresa;

        $totalTrabajadores = $empresa->trabajadores()->count();
        $limite = $empresa->limiteTrabajadores();

        // 🔥 Contadores métricos
        $vigentes = $empresa->trabajadores()
            ->where('estado', 'vigente')
            ->count();

        $inactivos = $empresa->trabajadores()
            ->where('estado', 'no_vigente')
            ->count();

        $plazoFijo = $empresa->trabajadores()
            ->where('tipo_contrato', 'plazo_fijo')
            ->count();

        $indefinido = $empresa->trabajadores()
            ->where('tipo_contrato', 'indefinido')
            ->count();

        // 🔥 Datos para gráfico por cargo
        $cargos = $empresa->trabajadores()
            ->select('cargo', \DB::raw('count(*) as total'))
            ->groupBy('cargo')
            ->pluck('total', 'cargo');

        return view('admin.dashboard', compact(
            'empresa',
            'totalTrabajadores',
            'limite',
            'cargos',
            'vigentes',
            'inactivos',
            'plazoFijo',
            'indefinido'
        ));

    })->name('admin.dashboard');

    Route::get('/trabajadores', [TrabajadorController::class, 'index'])  //para mostrar listado de trabajadores
        ->name('trabajadores.index');

    Route::get('/trabajadores/create', [TrabajadorController::class, 'create'])  //para mostrar el formulario de creación de trabajador
        ->name('trabajadores.create');

    Route::post('/trabajadores', [TrabajadorController::class, 'store'])  //para guardar nuevo trabajador
        ->name('trabajadores.store');

    Route::get('/trabajadores/{trabajador}/edit', [TrabajadorController::class, 'edit'])  //para mostrar el formulario de edición del trabajador
        ->name('trabajadores.edit');

    Route::put('/trabajadores/{trabajador}', [TrabajadorController::class, 'update']) //para actualizar datos del trabajador
        ->name('trabajadores.update');
    
    Route::post('/trabajadores/{trabajador}/documentos', [DocumentoController::class, 'store']) //para subir pdf
        ->name('trabajadores.documentos.store');
    
    Route::get('/trabajadores/inactivos', [TrabajadorController::class, 'inactivos'])  //para mostrar listado de trabajadores inactivos
        ->name('trabajadores.inactivos');

    Route::get('/trabajadores/{trabajador}/documentos/{documento}/download', [DocumentoController::class, 'download']) //para descargar pdf
        ->name('trabajadores.documentos.download');

    Route::delete('/trabajadores/{trabajador}/documentos/{documento}', [DocumentoController::class, 'destroy']) //para eliminar pdf
        ->name('trabajadores.documentos.destroy');
    
    Route::get('/trabajadores/export/excel', function () {   //para exportar excel
        return Excel::download(new TrabajadoresExport, 'trabajadores.xlsx');
    })->name('trabajadores.export.excel');

    Route::patch('/trabajadores/{trabajador}/reactivar',  //para reactivar trabajador inactivo
        [TrabajadorController::class, 'reactivar'])
        ->name('trabajadores.reactivar');

    Route::delete('/trabajadores/{trabajador}/eliminar-definitivo',   //para eliminar definitivamente un trabajador inactivo
        [TrabajadorController::class, 'eliminarDefinitivo'])
        ->name('trabajadores.eliminarDefinitivo');
    
    Route::get('/admin/administradores', [AdminController::class, 'index'])   // para mostrar listado de administradores
        ->name('admin.administradores.index');

    Route::get('/admin/administradores/create', [AdminController::class, 'create'])    // para mostrar formulario de creación de administrador
        ->name('admin.administradores.create');

    Route::post('/admin/administradores', [AdminController::class, 'store'])    // para guardar nuevo administrador
        ->name('admin.administradores.store');

    Route::delete('/admin/administradores/{user}',   // para eliminar administrador secundario
        [AdminController::class, 'destroy'])
        ->name('admin.administradores.destroy');
});

// áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de trabajador
    Route::middleware(['auth'])->group(function () {

        // PERFIL (Breeze)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // PORTAL TRABAJADOR
        Route::middleware(['role:trabajador'])
            ->prefix('worker')
            ->name('worker.')
            ->group(function () {
                Route::get('/dashboard', [WorkerController::class, 'dashboard'])
                    ->name('dashboard');
            });

    });

require __DIR__.'/auth.php';
