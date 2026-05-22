<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pago;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('empresa')
            ->latest()
            ->paginate(20);

        // 💰 KPIs
        $ingresosTotales = Pago::where('estado', 'pagado')
            ->sum('monto');

        $pagosPendientes = Pago::where('estado', 'pendiente')
            ->count();

        $pagosPagados = Pago::where('estado', 'pagado')
            ->count();

        // 🚨 Empresas con pagos pendientes
        $empresasMorosas = Pago::with('empresa')
            ->where('estado', 'pendiente')
            ->latest()
            ->take(10)
            ->get();

        // ⏳ Trials expirados
        $trialsExpirados = \App\Models\Empresa::whereNotNull('trial_hasta')
            ->where('trial_hasta', '<', now())
            ->where('estado', 'activa')
            ->get();


        return view('superadmin.pagos.index', compact(
            'pagos',
            'ingresosTotales',
            'pagosPendientes',
            'pagosPagados',
            'empresasMorosas',
            'trialsExpirados',
        ));
    }
}