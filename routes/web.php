<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\DocumentoController;
use App\Exports\TrabajadoresExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Worker\WorkerController;
use App\Http\Controllers\HoraExtraController;


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

    Route::get('/admin/documentos/carga-masiva', [DocumentoController::class, 'createCargaMasiva'])  // para mostrar formulario de carga masiva de documentos
        ->name('admin.documentos.carga');

    Route::post('/admin/documentos/carga-masiva', [DocumentoController::class, 'storeCargaMasiva'])  // para procesar carga masiva de documentos
        ->name('admin.documentos.carga.store');

    Route::get('/admin/documentos/progreso/{id}',    // para mostrar progreso de carga masiva de documentos
        [DocumentoController::class,'progreso']
        )->name('admin.carga.progreso');

    Route::get('/api/proceso/{id}', function($id){   // para obtener estado de proceso de carga masiva (usado por polling en frontend)
        return \App\Models\ProcesoCarga::findOrFail($id);
        });
    
    Route::get('/admin/horas-extras',                        // entrada principal del módulo para mostrar listado de trabajadores para gestionar horas extras
        [App\Http\Controllers\HoraExtraController::class, 'trabajadores']
    )->name('admin.horas_extras.trabajadores');

    Route::get('/trabajadores/{trabajador}/horas-extras',          // para mostrar horas extras de un trabajador específico y total del mes actual
        [App\Http\Controllers\HoraExtraController::class, 'index']
    )->name('admin.horas_extras.index');

    Route::post('/trabajadores/{trabajador}/horas-extras',      // para registrar una hora extra nueva para un trabajador específico
        [App\Http\Controllers\HoraExtraController::class, 'store']
    )->name('admin.horas_extras.store');

    Route::get('/admin/horas-extras/export/excel',     // para exportar excel con horas extras del mes actual de todos los trabajadores
        [HoraExtraController::class, 'exportExcel']
    )->name('admin.horas_extras.export');

});

// áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de trabajador
    Route::middleware(['auth'])->group(function () {

        // PERFIL (Breeze)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // ADMIN - crear acceso trabajador
        Route::post('/trabajadores/{trabajador}/acceso', [TrabajadorController::class, 'guardarAcceso'])
            ->name('trabajadores.acceso');
        
        Route::post('trabajadores/{trabajador}/reset-password', [TrabajadorController::class, 'resetPassword'])
            ->name('trabajadores.resetPassword');

        // PORTAL TRABAJADOR
        Route::middleware(['role:trabajador'])
            ->prefix('worker')
            ->name('worker.')
            ->group(function () {

                Route::get('/dashboard', [WorkerController::class, 'dashboard'])  // para mostrar dashboard del trabajador con sus datos y documentos
                    ->name('dashboard');
                
                Route::get('/documentos', [WorkerController::class, 'documentos'])  // para mostrar listado de documentos del trabajador
                    ->name('documentos');

                Route::get('/documentos/{documento}/download', [WorkerController::class, 'download'])  // para descargar documento del trabajador
                    ->name('documentos.download');

            });

    });

require __DIR__.'/auth.php';
