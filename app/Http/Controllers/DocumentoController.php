<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function store(Request $request, Trabajador $trabajador)
    {
        // 🔒 Seguridad: solo documentos de la empresa del admin logueado
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $request->validate([
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'fecha_documento'   => 'nullable|date',
            'observaciones'     => 'nullable|string|max:1000',
            'archivo'           => 'required|file|mimes:pdf|max:5120', // 5MB
        ]);

        // 📁 Guardar PDF en storage/app/public/documentos/{empresa}/{trabajador}/
        $path = $request->file('archivo')->store(
            "documentos/empresa_{$trabajador->empresa_id}/trabajador_{$trabajador->id}",
            'public'
        );

        Documento::create([
            'trabajador_id'     => $trabajador->id,
            'tipo_documento_id' => $request->tipo_documento_id,
            'ruta_archivo'      => $path,
            'fecha_documento'   => $request->fecha_documento,
            'observaciones'     => $request->observaciones,
        ]);

        return back()->with('success', 'Documento subido correctamente.');
    }

    public function destroy(Trabajador $trabajador, Documento $documento)
    {
        // 🔒 Seguridad: empresa + documento pertenece a ese trabajador
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) abort(403);
        if ($documento->trabajador_id !== $trabajador->id) abort(404);

        // 🧹 Borrar archivo físico
        if ($documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->delete();

        return back()->with('success', 'Documento eliminado.');
    }

    public function download(Trabajador $trabajador, Documento $documento)
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) abort(403);
        if ($documento->trabajador_id !== $trabajador->id) abort(404);

        $filename = "trabajador_{$trabajador->rut}_doc_{$documento->id}.pdf";

        return Storage::disk('public')->download($documento->ruta_archivo, $filename);
    }
}