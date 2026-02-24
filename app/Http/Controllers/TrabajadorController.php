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
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'rut' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:150',
            'sueldo' => 'nullable|numeric|min:0',
            'tipo_contrato' => 'nullable|in:plazo_fijo,indefinido',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'horario' => 'nullable|string|max:150',
            'estado' => 'required|in:vigente,no_vigente',
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
            'direccion' => $request->direccion,
            'cargo' => $request->cargo,
            'sueldo' => $request->sueldo,
            'tipo_contrato' => $request->tipo_contrato,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_salida' => $request->fecha_salida,
            'horario' => $request->horario,
            'estado' => $request->estado,
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