<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'empresa' => 'required|string|max:150',
            'rut' => 'required|string|max:20|unique:empresas,rut',
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        // 🔹 Crear empresa
        $empresa = Empresa::create([
            'nombre' => $request->empresa,
            'rut' => $request->rut,
            'plan' => 'basico',
            'estado' => 'activa',
            'trial_hasta' => now()->addDays(3),
        ]);

        // 🔹 Crear usuario administrador
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $empresa->id,
            'rol' => 'admin_primario',
        ]);

        // 🔹 Login automático
        Auth::login($user);

        // 🔹 Redirección
        return redirect()->route('registro.exitoso');
    }
}