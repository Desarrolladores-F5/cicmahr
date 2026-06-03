<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SuscripcionController extends Controller
{
    public function index()
    {
        $empresa = Auth::user()->empresa;

        $ultimoPago = $empresa->pagos()
            ->latest()
            ->first();

        $pagos = $empresa->pagos()
            ->latest()
            ->take(10)
            ->get();

        $diasRestantes = null;

        if ($empresa->suscripcion_hasta) {
            $diasRestantes = (int) ceil(
                now()->diffInRealDays($empresa->suscripcion_hasta, false)
            );
        }

        $nombrePlan = '-';

        if ($ultimoPago) {

            $nombrePlan = match ($ultimoPago->periodo_meses) {
                1 => '1 Mes',
                3 => '3 Meses',
                6 => '6 Meses',
                12 => '1 Año',
                default => '-',
            };
        }

        return view(
            'admin.suscripcion.index',
            compact('empresa', 'ultimoPago', 'pagos', 'diasRestantes', 'nombrePlan')
        );
    }
}