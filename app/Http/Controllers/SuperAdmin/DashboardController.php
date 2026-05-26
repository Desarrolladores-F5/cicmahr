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

        // 💰 MRR (pagos del mes actual)
        $mrr = Pago::where('estado', 'pagado')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('monto');

        // 🏢 Nuevas empresas este mes
        $nuevasEmpresasMes = Empresa::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 👷 Nuevos trabajadores este mes
        $nuevosTrabajadoresMes = Trabajador::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 💳 Pagos pendientes
        $pagosPendientes = Pago::where('estado', 'pendiente')->count();


        $ultimasEmpresas = Empresa::latest()->take(5)->get();
        $ultimosPagos = Pago::with('empresa')->latest()->take(5)->get();

        // 📈 EMPRESAS POR MES
        $empresasPorMes = [];

        for ($i = 5; $i >= 0; $i--) {

            $mes = now()->subMonths($i);

            $empresasPorMes[] = [
                'mes' => $mes->format('M Y'),
                'total' => Empresa::whereMonth('created_at', $mes->month)
                    ->whereYear('created_at', $mes->year)
                    ->count()
            ];
        }

        // 💰 INGRESOS POR MES
        $ingresosPorMes = [];

        for ($i = 5; $i >= 0; $i--) {

            $mes = now()->subMonths($i);

            $ingresosPorMes[] = [
                'mes' => $mes->format('M Y'),
                'total' => Pago::where('estado', 'pagado')
                    ->whereMonth('created_at', $mes->month)
                    ->whereYear('created_at', $mes->year)
                    ->sum('monto')
            ];
        }

        // 📉 CHURN RATE
        $churnRate = 0;

        if ($totalEmpresas > 0) {
            $churnRate = round(
                ($empresasSuspendidas / $totalEmpresas) * 100,
                1
            );
        }

        // 💰 ARPU
        $arpu = 0;

        if ($empresasActivas > 0) {
            $arpu = round(
                $ingresosTotales / $empresasActivas
            );
        }

        // 📈 CRECIMIENTO MENSUAL
        $empresasMesActual = Empresa::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $empresasMesAnterior = Empresa::whereMonth(
                'created_at',
                now()->subMonth()->month
            )
            ->whereYear(
                'created_at',
                now()->subMonth()->year
            )
            ->count();

        $growthRate = 0;

        if ($empresasMesAnterior > 0) {

            $growthRate = round(
                (
                    ($empresasMesActual - $empresasMesAnterior)
                    / $empresasMesAnterior
                ) * 100,
                1
            );
        }

        // 🚀 TRIAL → PAGO
        $empresasConPago = Empresa::whereHas('pagos', function ($query) {
            $query->where('estado', 'pagado');
        })->count();

        $trialConversion = 0;

        if ($totalEmpresas > 0) {

            $trialConversion = round(
                ($empresasConPago / $totalEmpresas) * 100,
                1
            );
        }

        return view('superadmin.dashboard', compact(
            'totalEmpresas',
            'empresasActivas',
            'empresasSuspendidas',
            'empresasEnTrial',
            'totalPagos',
            'ingresosTotales',
            'totalTrabajadores',
            'ultimasEmpresas',
            'ultimosPagos',
            'mrr',
            'nuevasEmpresasMes',
            'nuevosTrabajadoresMes',
            'pagosPendientes',
            'empresasPorMes',
            'ingresosPorMes',
            'churnRate',
            'arpu',
            'growthRate',
            'trialConversion',
        ));
    }
}