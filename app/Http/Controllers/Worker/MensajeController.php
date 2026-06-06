<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MensajeUser;


class MensajeController extends Controller
{
    public function index()
    {
        $mensajes = MensajeUser::with('mensaje')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'worker.mensajes.index',
            compact('mensajes')
        );
    }

    public function show(MensajeUser $mensajeUser)
    {
        // Seguridad: sólo puede abrir sus propios mensajes
        if ($mensajeUser->user_id !== auth()->id()) {
            abort(403);
        }

        // Marcar como leído automáticamente
        if (!$mensajeUser->leido) {

            $mensajeUser->update([
                'leido' => true,
                'fecha_lectura' => now(),
            ]);
        }

        return view(
            'worker.mensajes.show',
            compact('mensajeUser')
        );
    }
}