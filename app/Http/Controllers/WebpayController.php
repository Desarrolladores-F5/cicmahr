<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\Options;
use App\Models\Empresa;
use App\Models\Pago;

class WebpayController extends Controller
{
    public function iniciar($meses)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        $buyOrder = 'CICMA_' . $empresa->id . '_' . $meses . '_' . time();
        $sessionId = session()->getId();
        $planes = [
            1  => 19990,
            3  => 50990,
            6  => 109990,
            12 => 179000,
        ];

        $amount = $planes[$meses] ?? 19990;


        $returnUrl = route('webpay.retorno');

        $options = new Options(
            config('webpay.api_key'),        // primero API KEY
            config('webpay.commerce_code'),  // después COMMERCE CODE
            config('webpay.environment') === 'production'
                ? Options::ENVIRONMENT_PRODUCTION
                : Options::ENVIRONMENT_INTEGRATION
        );

        $tx = new Transaction($options);

        try {
            $response = $tx->create(
                $buyOrder,
                $sessionId,
                $amount,
                $returnUrl
            );

            //dd($response);

            return redirect($response->getUrl() . '?token_ws=' . $response->getToken());

        } 
        
        catch (\Exception $e) {
            return redirect()->route('activar.cuenta')
                ->with('error', 'Error al iniciar el pago: ' . $e->getMessage());
        }
    }

    public function retorno(Request $request)
    {
        $token = $request->input('token_ws');

        if (!$token) {
            return redirect()->route('activar.cuenta')
                ->with('error', 'No se recibió el token de Webpay.');
        }

        $options = new Options(
            config('webpay.api_key'),        // primero API KEY
            config('webpay.commerce_code'),  // después COMMERCE CODE
            config('webpay.environment') === 'production'
                ? Options::ENVIRONMENT_PRODUCTION
                : Options::ENVIRONMENT_INTEGRATION
        );

        $tx = new Transaction($options);

        try {
            $response = $tx->commit($token);

            if ($response->getStatus() === 'AUTHORIZED') {

                $buyOrder = $response->getBuyOrder();

                $partes = explode('_', $buyOrder);

                $empresaId = $partes[1] ?? null;
                $periodoMeses = (int) ($partes[2] ?? 1);

                $empresa = Empresa::find($empresaId);

                if ($empresa) {

                    // 🔹 Activar empresa y extender suscripción
                    $empresa->update([
                        'trial_hasta' => null,
                        'estado' => 'activa',
                        'suscripcion_activa' => true,
                        'suscripcion_hasta' => now()->addMonths($periodoMeses),
                    ]);

                    // 🔹 Guardar pago en BD
                    Pago::create([
                        'empresa_id' => $empresa->id,
                        'orden' => $buyOrder,
                        'monto' => $response->getAmount(),
                        'periodo_meses' => $periodoMeses,
                        'estado' => 'pagado',
                        'fecha_pago' => now(),
                    ]);
                }

                return redirect()->route('dashboard', ['pago' => 'ok']);
                    
            }

            return redirect()->route('activar.cuenta')
                ->with('error', 'El pago fue rechazado.');

        } catch (\Exception $e) {
            return redirect()->route('activar.cuenta')
                ->with('error', 'Error al confirmar el pago: ' . $e->getMessage());
        }
    }
}