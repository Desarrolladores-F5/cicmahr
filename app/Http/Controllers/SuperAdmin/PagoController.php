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

        return view('superadmin.pagos.index', compact(
            'pagos',
            'ingresosTotales',
            'pagosPendientes',
            'pagosPagados'
        ));
    }
}