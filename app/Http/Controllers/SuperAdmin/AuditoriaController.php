<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActividadUsuario;

class AuditoriaController extends Controller
{
    public function index()
    {
        $actividades = ActividadUsuario::with('user.empresa')
            ->latest()
            ->paginate(25);

        return view('superadmin.auditoria.index', compact('actividades'));
    }
}