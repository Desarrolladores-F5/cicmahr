<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\Options;
use App\Models\Empresa;

class WebpayController extends Controller
{
    public function iniciar()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        $buyOrder = 'CICMA_' . $empresa->id . '_' . time();
        $sessionId = session()->getId();
        $amount = 9990;
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

                $empresa = Empresa::find($empresaId);

                if ($empresa) {
                    $empresa->update([
                        'trial_hasta' => null,
                        'estado' => 'activa',
                        'suscripcion_activa' => true,
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