<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\Documento;
use App\Models\HoraExtra;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $empresaId = auth()->user()->empresa_id;

        $trabajadores = collect();
        $documentos = collect();
        $horasExtras = collect();

        if ($q) {

            // 👥 TRABAJADORES
            $trabajadores = Trabajador::where('empresa_id', $empresaId)
                ->where(function ($query) use ($q) {
                    $query->where('nombre', 'like', "%$q%")
                        ->orWhere('apellido', 'like', "%$q%")
                        ->orWhere('rut', 'like', "%$q%");
                })
                ->get();

            $trabajadores = $trabajadores->sortByDesc(function ($t) use ($q) {
                similar_text(
                    strtolower($t->nombre . ' ' . $t->apellido),
                    strtolower($q),
                    $percent
                );
                return $percent;
            });

            // 📄 DOCUMENTOS
            $documentos = Documento::with('trabajador')
                ->whereIn('trabajador_id', $trabajadores->pluck('id'))
                ->get();

            // ⏱ HORAS EXTRAS
            $horasExtras = HoraExtra::with('trabajador')
                ->whereIn('trabajador_id', $trabajadores->pluck('id'))
                ->get();
        }

        return view('busqueda.index', compact(
            'q',
            'trabajadores',
            'documentos',
            'horasExtras'
        ));
    }
}