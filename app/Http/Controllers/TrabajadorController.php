<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\TipoDocumento;

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

    public function index(Request $request)   // 🔥 NUEVO MÉTODO PARA LISTAR LOS TRABAJADORES CON FILTROS DE BÚSQUEDA
    {
        $empresaId = auth()->user()->empresa_id;

        $query = Trabajador::where('empresa_id', $empresaId)->where('estado', 'vigente');
                            

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->where('rut', 'like', "%{$buscar}%")
                ->orWhere('nombre', 'like', "%{$buscar}%")
                ->orWhere('apellido', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        $trabajadores = $query
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('trabajadores.index', compact('trabajadores'));
    }

    public function edit(Trabajador $trabajador)    // 🔥 NUEVO MÉTODO PARA MOSTRAR EL FORMULARIO DE EDICIÓN DE UN TRABAJADOR
    {
        // Seguridad: evitar que editen trabajador de otra empresa
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $tiposDocumento = TipoDocumento::orderBy('nombre_documento')->get();

        $documentos = $trabajador->documentos()
            ->with('tipoDocumento')
            ->orderByDesc('fecha_documento')
            ->orderByDesc('created_at')
            ->get();

        return view('trabajadores.edit', compact('trabajador', 'tiposDocumento', 'documentos'));
    }

    public function update(Request $request, Trabajador $trabajador)  // 🔥 NUEVO MÉTODO PARA ACTUALIZAR LOS DATOS DE UN TRABAJADOR
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $request->validate([                          //Fíjate que NO incluimos RUT en validación porque no lo vamos a modificar nunca, es un id.
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'direccion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:150',
            'sueldo' => 'nullable|numeric',
            'tipo_contrato' => 'nullable|in:plazo_fijo,indefinido',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'estado' => 'required|in:vigente,no_vigente',
            'horario' => 'nullable|string|max:150',
        ]);

        // Lógica de contratos inteligente, aunque alguien manipule el HTML, el backend lo corrige.
        $data = $request->all();

        if ($request->tipo_contrato === 'indefinido') {
            $data['fecha_salida'] = null;
        }

        $trabajador->update($data);

        return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    public function inactivos()
    {
        $empresaId = auth()->user()->empresa_id;

        $trabajadores = Trabajador::where('empresa_id', $empresaId)
            ->where('estado', 'no_vigente')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('trabajadores.inactivos', compact('trabajadores'));
    }

    public function reactivar(Trabajador $trabajador)
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $trabajador->update([
            'estado' => 'vigente'
        ]);

        return redirect()->route('trabajadores.inactivos')
            ->with('success', 'Trabajador reactivado correctamente.');
    }


    public function eliminarDefinitivo(Trabajador $trabajador)
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        if ($trabajador->estado !== 'no_vigente') {
            abort(403);
        }

        $trabajador->delete();

        return redirect()->route('trabajadores.inactivos')
            ->with('success', 'Trabajador eliminado definitivamente.');
    }
}