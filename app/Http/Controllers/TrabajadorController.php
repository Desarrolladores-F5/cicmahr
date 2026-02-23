<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;

class TrabajadorController extends Controller   // 🔥 NUEVO CONTROLADOR PARA GESTIONAR TRABAJADORES
{
    public function create()
    {
        return view('admin.trabajadores.create');
    }

    public function store(Request $request)  // 🔥 NUEVO MÉTODO PARA GUARDAR UN NUEVO TRABAJADOR
    {
        
        $empresa = auth()->user()->empresa;

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:20',
            'cargo' => 'required|string|max:255',
        ]);

        // 🔥 VALIDACIÓN DE PLAN
        if (!$empresa->puedeAgregarTrabajador()) {
            return redirect()
                ->back()
                ->with('error', 'Has alcanzado el límite de trabajadores de tu plan.');
        }

        Trabajador::create([
            'empresa_id' => $empresa->id,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'rut' => $request->rut,
            'cargo' => $request->cargo,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Trabajador registrado correctamente.');
    }

    public function index()
    {
        $empresa = auth()->user()->empresa;

        $trabajadores = $empresa->trabajadores()->latest()->get();

        return view('trabajadores.index', compact('trabajadores'));
    }
}