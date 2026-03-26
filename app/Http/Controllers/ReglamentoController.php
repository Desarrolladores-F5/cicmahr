<?php

namespace App\Http\Controllers;

use App\Models\Reglamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ReglamentoEntrega;
use Carbon\Carbon;

class ReglamentoController extends Controller
{
    public function index()    // Esta función se encarga de mostrar el listado de reglamentos de la empresa.
    {
        $empresa = auth()->user()->empresa;

        $reglamentos = $empresa->reglamentos()
            ->latest()
            ->get();

        return view('admin.reglamentos.index', compact('reglamentos'));
    }

    public function store(Request $request)    // Esta función se encarga de subir un nuevo reglamento para la empresa.
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'anio' => 'required|digits:4|integer',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'descripcion' => 'nullable|string',
        ]);

        $empresa = auth()->user()->empresa;

        $rutaArchivo = $request->file('archivo')->store('reglamentos', 'public');

        Reglamento::create([
            'empresa_id' => $empresa->id,
            'nombre' => $request->nombre,
            'anio' => $request->anio,
            'archivo' => $rutaArchivo,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Reglamento subido correctamente.');
    }

    public function download(Reglamento $reglamento) // Esta función se encarga de descargar el archivo del reglamento.
    {
        $empresa = auth()->user()->empresa;
        $trabajador = auth()->user()->trabajador;

        if ($reglamento->empresa_id !== $empresa->id) {
            abort(403);
        }

        // 🔥 MARCAR COMO LEÍDO AL DESCARGAR
        ReglamentoEntrega::updateOrCreate(
            [
                'reglamento_id' => $reglamento->id,
                'trabajador_id' => $trabajador->id,
            ],
            [
                'leido' => true,
                'fecha_lectura' => now(),
            ]
        );

        return Storage::disk('public')->download($reglamento->archivo);
    }

    public function indexWorker()  // Esta función se encarga de mostrar el listado de reglamentos para el trabajador, indicando cuáles ha leído y cuáles no.
    {
        $empresa = auth()->user()->empresa;
        $trabajador = auth()->user()->trabajador;

        $reglamentos = $empresa->reglamentos()->latest()->get();

        $entregas = ReglamentoEntrega::where('trabajador_id', $trabajador->id)
            ->get()
            ->keyBy('reglamento_id');

        $pendientes = $reglamentos->filter(function ($reglamento) use ($entregas) {
            return !isset($entregas[$reglamento->id]) || !$entregas[$reglamento->id]->leido;
        })->count();
        
        return view('worker.reglamentos.index', compact('reglamentos', 'entregas', 'pendientes'));
    }

    public function aceptar(Request $request, Reglamento $reglamento)  // Para registrar que el trabajador ha aceptado el reglamento, marcándolo como leído.
    {
        $request->validate([
            'acepta_lectura' => 'accepted',
        ]);
    
        $trabajador = auth()->user()->trabajador;

        ReglamentoEntrega::updateOrCreate(
            [
                'reglamento_id' => $reglamento->id,
                'trabajador_id' => $trabajador->id,
            ],
            [
                'leido' => true,
                'fecha_lectura' => now(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        return back()->with('success', 'Reglamento aceptado correctamente.');
    }
}