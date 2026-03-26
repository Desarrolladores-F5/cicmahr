<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use App\Models\ReglamentoEntrega;

class WorkerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $trabajador = $user->trabajador;

        if (!$trabajador) {

            auth()->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Tu acceso ya no está disponible. Contacta al administrador.'
                ]);
        }

        $totalMesActual = \App\Models\HoraExtra::where('trabajador_id', $trabajador->id)  // total de horas extras del mes actual
            ->where('estado', 'aprobado')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('horas');


        $documentos = \App\Models\Documento::with('tipoDocumento')  // últimos 5 documentos del trabajador
            ->where('trabajador_id', $trabajador->id)
            ->latest()
            ->take(5)
            ->get();

        $totalDocumentos = \App\Models\Documento::where('trabajador_id', $trabajador->id)->count();  // total de documentos del trabajador

        $nuevosDocumentos = \App\Models\Documento::where('trabajador_id', $trabajador->id)  // documentos subidos en los últimos 30 días
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->count();

        $reglamentos = $trabajador->empresa->reglamentos;

        $entregas = ReglamentoEntrega::where('trabajador_id', $trabajador->id)
            ->get()
            ->keyBy('reglamento_id');

        $pendientesReglamentos = $reglamentos->filter(function ($reglamento) use ($entregas) {
            return !isset($entregas[$reglamento->id]) || !$entregas[$reglamento->id]->leido;
        })->count();

        return view('worker.dashboard', compact('trabajador', 'documentos', 'totalDocumentos', 'nuevosDocumentos', 'totalMesActual', 'pendientesReglamentos'));
    }

    public function documentos()  // para mostrar listado de documentos del trabajador
    {
        $user = auth()->user();

        // trabajador asociado al usuario
        $trabajador = $user->trabajador;

        // Si el usuario no tiene un trabajador asociado, denegar acceso
        if (!$trabajador) {
            abort(403, 'No tienes un trabajador asociado.');
        }

        // documentos del trabajador
        $documentos = \App\Models\Documento::with('tipoDocumento')
            ->where('trabajador_id', $trabajador->id)
            ->latest()
            ->get();

        return view('worker.documentos', compact('trabajador', 'documentos'));
    }

    public function download(Documento $documento)  // para descargar un documento específico
    {
        $user = auth()->user();

        // El trabajador logueado debe existir y estar vinculado
        $trabajador = $user->trabajador;

        if (!$trabajador) {
            abort(403, 'No tienes un trabajador asociado.');
        }

        // Seguridad: el documento debe pertenecer a ESTE trabajador
        if ((int) $documento->trabajador_id !== (int) $trabajador->id) {
            abort(403, 'Acceso no autorizado.');
        }

        $nombre = 'documento_' . $documento->id . '.pdf';

        // Descargar desde storage/app/public/...
        return Storage::disk('public')->download($documento->ruta_archivo, $nombre);
    }
}
