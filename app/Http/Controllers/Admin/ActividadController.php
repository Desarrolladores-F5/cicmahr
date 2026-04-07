<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActividadUsuario;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = ActividadUsuario::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.historial.index', compact('actividades'));
    }
}