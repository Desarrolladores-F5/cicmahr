<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActividadUsuario;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(Request $request)    // 📋 DEL HISTORIAL DE REGISTRO, Listado de actividades con filtros
    {
        $query = \App\Models\ActividadUsuario::with('user')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->latest();

        $estadisticas = \App\Models\ActividadUsuario::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->take(7)
            ->get();

        // 🔍 Buscar en descripción
        if ($request->filled('buscar')) {
            $query->where('descripcion', 'like', '%' . $request->buscar . '%');
        }

        // 🎯 Filtro por módulo
        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }

        // 👤 Filtro por usuario
        if ($request->filled('usuario')) {
            $query->where('user_id', $request->usuario);
        }

        // 📅 Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        // 📅 Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $actividades = $query->paginate(15)->withQueryString();

        // 📊 Lista de módulos únicos
        $modulos = \App\Models\ActividadUsuario::select('modulo')
            ->distinct()
            ->pluck('modulo');

        // 👤 Lista de usuarios únicos
        $usuarios = \App\Models\User::select('id', 'name')
            ->whereIn('id', \App\Models\ActividadUsuario::pluck('user_id')->unique())
            ->orderBy('name')
            ->get();

        return view('admin.historial.index', compact('actividades', 'modulos', 'usuarios', 'estadisticas'));
    }
}