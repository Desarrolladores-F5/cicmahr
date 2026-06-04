<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use App\Models\MensajeUser;
use App\Models\User;

class MensajeController extends Controller
{
    public function index()
    {
        $empresa = Auth::user()->empresa;

        $mensajes = Mensaje::where('empresa_id', $empresa->id)
            ->latest()
            ->paginate(10);

        return view(
            'admin.mensajeria.index',
            compact('mensajes')
        );
    }

    public function create()
    {
        $empresa = Auth::user()->empresa;

        $trabajadores = User::where('empresa_id', $empresa->id)
            ->where('rol', 'trabajador')
            ->orderBy('name')
            ->get();

        return view(
            'admin.mensajeria.create',
            compact('trabajadores')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'mensaje' => 'required',
        ]);

        $empresa = Auth::user()->empresa;

        $mensaje = Mensaje::create([
            'empresa_id' => $empresa->id,
            'remitente_id' => Auth::id(),
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'para_todos' => $request->boolean('para_todos'),
        ]);

        // Enviar a todos los trabajadores
        if ($request->boolean('para_todos')) {

            $trabajadores = User::where('empresa_id', $empresa->id)
                ->where('rol', 'trabajador')
                ->get();

            foreach ($trabajadores as $trabajador) {

                MensajeUser::create([
                    'mensaje_id' => $mensaje->id,
                    'user_id' => $trabajador->id,
                ]);
            }

        } else {

            // Enviar a un trabajador específico

            MensajeUser::create([
                'mensaje_id' => $mensaje->id,
                'user_id' => $request->user_id,
            ]);
        }

        return redirect()
            ->route('admin.mensajes.index')
            ->with(
                'success',
                'Mensaje enviado correctamente.'
            );
    }
}