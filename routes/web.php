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
use App\Http\Controllers\WorkerHoraExtraController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\ReglamentoController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\WebpayController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\EmpresaController as SuperAdminEmpresaController;
use App\Http\Controllers\SuperAdmin\AuditoriaController as SuperAdminAuditoriaController;
use App\Http\Controllers\SuperAdmin\PagoController as SuperAdminPagoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SuscripcionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registro', function () {  // ruta para mostrar el registro para nuevos clientes desde el welcome..blade.php
    return view('registro');
})->name('registro');

Route::post('/registro', [RegistroController::class, 'store'])  // ruta para procesar el formulario de registro y crear empresa + usuario admin
    ->name('registro.store');

Route::get('/registro-exitoso', function () {  // ruta para mostrar mensaje de registro exitoso después de que el cliente envíe el formulario de registro
    return view('registro-exitoso');
})->name('registro.exitoso');

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

})->middleware(['auth', 'trial'])->name('dashboard');

Route::get('/trial-expirado', function () {    // ruta para mostrar mensaje de trial expirado.
    return view('trial-expirado');
})->middleware(['auth'])->name('trial.expirado');

Route::get('/activar-cuenta', function () {   // ruta para mostrar mensaje de cuenta inactiva (antes de activar trial por primera vez)
    return redirect()->route('planes.index');
})->middleware(['auth'])->name('activar.cuenta');

Route::get('/webpay/iniciar/{meses}', [WebpayController::class, 'iniciar'])    // ruta para iniciar proceso de pago con Webpay
    ->middleware(['auth'])
    ->name('webpay.iniciar');

Route::match(['GET', 'POST'], '/webpay/retorno', [WebpayController::class, 'retorno'])    // ruta para manejar retorno de Webpay después del proceso de pago (tanto GET como POST por seguridad)
    ->middleware(['auth'])
    ->name('webpay.retorno');

Route::middleware(['auth'])->group(function () {                        // grupo de rutas que requieren autenticación, pero no rol específico (pueden ser accedidas por admin o trabajador)

    Route::get('/planes', [PlanController::class, 'index'])            // ruta para mostrar listado de planes disponibles para activar trial o comprar suscripción
        ->name('planes.index');

});

// Dashboard Admin - áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de admin
Route::middleware(['auth', 'trial','admin','preventBackHistory', 'empresa.status'])->group(function () {
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

        // 🔥 Contador de solicitudes de vacaciones pendientes
        $vacacionesPendientes = \App\Models\Vacacion::where('estado', 'pendiente')->count();

        return view('admin.dashboard', compact(
            'empresa',
            'totalTrabajadores',
            'limite',
            'cargos',
            'vigentes',
            'inactivos',
            'plazoFijo',
            'indefinido',
            'vacacionesPendientes'
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

    Route::patch('/horas-extras/{horaExtra}/aprobar', [HoraExtraController::class, 'aprobar'])
    ->name('admin.horas_extras.aprobar');

    Route::patch('/horas-extras/{horaExtra}/rechazar', [HoraExtraController::class, 'rechazar'])
    ->name('admin.horas_extras.rechazar');


    Route::get('/admin/horas-extras/export/excel',     // para exportar excel con horas extras del mes actual de todos los trabajadores
        [HoraExtraController::class, 'exportExcel']
    )->name('admin.horas_extras.export');

    Route::get('/admin/vacaciones', [VacacionController::class, 'indexAdmin'])  // para mostrar listado de solicitudes de vacaciones de todos los trabajadores para que el admin pueda aprobar o rechazar
        ->name('admin.vacaciones');

    Route::post('/admin/vacaciones/{vacacion}/aprobar', [VacacionController::class, 'aprobar'])  // para aprobar solicitud de vacaciones
        ->name('admin.vacaciones.aprobar');

    Route::post('/admin/vacaciones/{vacacion}/rechazar', [VacacionController::class, 'rechazar']) // para rechazar solicitud de vacaciones
        ->name('admin.vacaciones.rechazar');

    Route::get('/admin/reglamentos', [ReglamentoController::class, 'index'])  // Ruta encargada de mostrar el listado de reglamentos de la empresa.
        ->name('admin.reglamentos.index');

    Route::post('/admin/reglamentos', [ReglamentoController::class, 'store'])  // Ruta encargada de subir un nuevo reglamento para la empresa.
        ->name('admin.reglamentos.store');

    Route::get('/admin/reglamentos/{reglamento}/download', [ReglamentoController::class, 'download'])   // Ruta encargada de descargar el archivo del reglamento.
        ->name('admin.reglamentos.download');

    Route::get('/historial', [\App\Http\Controllers\Admin\ActividadController::class, 'index'])  // Ruta encargada de mostrar el historial de actividades de los usuarios en el sistema.
        ->name('admin.historial.index');

    Route::get('/busqueda', [BusquedaController::class, 'index'])    // Ruta encargada de Busqueda Avanzada.
        ->name('busqueda.index');

    Route::get('/documentos/{trabajador}/{documento}/download',    // para descargar documento del trabajador desde el historial de actividades o resultados de búsqueda
            [DocumentoController::class, 'download']
        )->name('documentos.download');

    Route::get('/suscripcion', [SuscripcionController::class, 'index'])  // Ruta encargada de mostrar la pestaña Suscripción en el menú de administrador.
        ->name('suscripcion.index');

});

// áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de trabajador
    Route::middleware(['auth', 'trial','preventBackHistory', 'empresa.status'])->group(function () {

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

            Route::get('/horas-extras', [WorkerHoraExtraController::class, 'index']  // para mostrar horas extras del trabajador y total del mes actual
                )->name('horas_extras');

            Route::post('/vacaciones', [VacacionController::class, 'store'])    // para solicitar vacaciones
                ->name('vacaciones.store');
            
            Route::get('/vacaciones', function () {return view('worker.vacaciones.index');})  // para mostrar formulario de solicitud de vacaciones
                ->name('vacaciones');
            
            Route::get('/vacaciones', [VacacionController::class, 'indexWorker'])   // para mostrar listado de solicitudes de vacaciones del trabajador autenticado
                ->name('vacaciones');

            Route::get('/reglamentos', [ReglamentoController::class, 'indexWorker'])  // Ruta encargada de mostrar el listado de reglamentos de la empresa al trabajador.
                ->name('reglamentos.index');

            Route::get('/reglamentos/{reglamento}/download', [ReglamentoController::class, 'download'])  // Ruta encargada de descargar el reglamento del trabajador.
                ->name('reglamentos.download');

            Route::post('/reglamentos/{reglamento}/aceptar', [ReglamentoController::class, 'aceptar'])   // Ruta encargada de registrar que el trabajador ha aceptado el reglamento.
                ->name('reglamentos.aceptar');

        });

    });

// Dashboard SuperAdmin - áca creamos un grupo de rutas que solo pueden ser accedidas por usuarios autenticados y con rol de superadmin
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'superadmin', 'preventBackHistory', 'empresa.status'])
    ->group(function () {

        Route::get('/', [SuperAdminDashboardController::class, 'index'])  // para mostrar dashboard del superadmin con métricas globales
            ->name('dashboard');

        Route::get('/empresas', [SuperAdminEmpresaController::class, 'index'])  // para mostrar listado de empresas registradas en el sistema
            ->name('empresas.index');

        Route::get('/empresas/{empresa}', [SuperAdminEmpresaController::class, 'show'])  // para mostrar detalle de una empresa específica con listado de sus trabajadores y documentos
            ->name('empresas.show');

        Route::post('/empresas/{empresa}/entrar', [SuperAdminEmpresaController::class, 'entrar'])  // para entrar al dashboard de una empresa específica sin necesidad de credenciales (función "entrar como esta empresa")
            ->name('empresas.entrar');

        Route::post('/empresas/{empresa}/suspender', [SuperAdminEmpresaController::class, 'suspender'])    // para suspender una empresa (desactiva su cuenta y bloquea acceso a dashboard admin)
            ->name('empresas.suspender');

        Route::post('/empresas/{empresa}/reactivar', [SuperAdminEmpresaController::class, 'reactivar'])   // para reactivar una empresa suspendida (restaura acceso a dashboard admin)
            ->name('empresas.reactivar');

        Route::get('/empresas/{empresa}/editar-rut', [SuperAdminEmpresaController::class, 'editRut'])   // para mostrar formulario de edición del RUT de la empresa
            ->name('empresas.editRut');

        Route::patch('/empresas/{empresa}/actualizar-rut', [SuperAdminEmpresaController::class, 'updateRut'])    // para actualizar el RUT de la empresa
            ->name('empresas.updateRut');

        Route::get('/trabajadores/{trabajador}/editar-rut', [SuperAdminEmpresaController::class, 'editRutTrabajador'])   // para mostrar formulario de edición del RUT de un trabajador específico
            ->name('trabajadores.editRut');

        Route::patch('/trabajadores/{trabajador}/actualizar-rut', [SuperAdminEmpresaController::class, 'updateRutTrabajador'])   // para actualizar el RUT de un trabajador específico
            ->name('trabajadores.updateRut');

        Route::get('/auditoria', [SuperAdminAuditoriaController::class, 'index'])  // para mostrar listado de actividades de los usuarios en el sistema (auditoría)
            ->name('auditoria.index');

        Route::get('/pagos', [SuperAdminPagoController::class, 'index'])         // para mostrar listado de pagos realizados por las empresas.
            ->name('pagos.index');

    });

    Route::middleware('auth')->group(function () {

    Route::post('/superadmin/volver', [SuperAdminEmpresaController::class, 'volver'])    // para volver a la sesión original del superadmin después de haber entrado como empresa
        ->name('superadmin.volver');

    });

    

    
require __DIR__.'/auth.php';