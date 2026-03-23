<?php

namespace App\Http\Controllers;

use App\Models\Reglamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($reglamento->empresa_id !== $empresa->id) {
            abort(403);
        }

        return Storage::disk('public')->download($reglamento->archivo);
    }

    public function indexWorker()    // Esta función se encarga de mostrar el listado de reglamentos den la VISTA TRABAJADOR.
    {
        $empresa = auth()->user()->empresa;

        $reglamentos = $empresa->reglamentos()
            ->latest()
            ->get();

        return view('worker.reglamentos.index', compact('reglamentos'));
    }
}