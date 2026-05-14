<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;                  // 👈 se importa el modelo Empresa para obtener estadísticas
use App\Models\Pago;                   // 👈 se importa el modelo Pago para obtener estadísticas de pagos
use App\Models\Trabajador;            // 👈 se importa el modelo Trabajador para obtener estadísticas de trabajadores

class DashboardController extends Controller
{  
    public function index()  // 👈 se agrega el método index para mostrar el dashboard
    {
        $totalEmpresas = Empresa::count();
        $empresasActivas = Empresa::where('estado', 'activa')->count();
        $empresasSuspendidas = Empresa::where('estado', 'suspendida')->count();

        $empresasEnTrial = Empresa::whereNotNull('trial_hasta')
            ->where('trial_hasta', '>=', now())
            ->count();

        $totalPagos = Pago::count();
        $ingresosTotales = Pago::where('estado', 'pagado')->sum('monto');

        $totalTrabajadores = Trabajador::count();

        $ultimasEmpresas = Empresa::latest()->take(5)->get();
        $ultimosPagos = Pago::with('empresa')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalEmpresas',
            'empresasActivas',
            'empresasSuspendidas',
            'empresasEnTrial',
            'totalPagos',
            'ingresosTotales',
            'totalTrabajadores',
            'ultimasEmpresas',
            'ultimosPagos'
        ));
    }
}