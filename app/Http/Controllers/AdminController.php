<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $empresa = auth()->user()->empresa;

        $administradores = $empresa->users()
            ->whereIn('rol', ['admin_primario', 'admin_secundario'])
            ->orderBy('rol') // primario arriba
            ->get();

        $limite = $empresa->limiteAdministradores();

        return view('admin.administradores.index', compact('administradores', 'limite'));
    }

    public function create()
    {
        $empresa = auth()->user()->empresa;

        if (!$empresa->puedeAgregarAdministrador()) {
            return redirect()
                ->route('admin.administradores.index')
                ->with('error', 'Has alcanzado el límite de administradores de tu plan.');
        }

        return view('admin.administradores.create');
    }

    public function store(Request $request)
    {
        $empresa = auth()->user()->empresa;

        if (!$empresa->puedeAgregarAdministrador()) {
            return redirect()
                ->route('admin.administradores.index')
                ->with('error', 'Has alcanzado el límite de administradores de tu plan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $empresa->id,
            'rol' => 'admin_secundario',
            'estado' => 'activo',
            'must_change_password' => true, // para que cambie al entrar
        ]);

        return redirect()
            ->route('admin.administradores.index')
            ->with('success', 'Administrador secundario creado correctamente.');
    }

    public function destroy(User $user)     // para eliminar administrador secundario
    {
        $empresa = auth()->user()->empresa;

        // Debe pertenecer a la misma empresa
        if ($user->empresa_id !== $empresa->id) {
            abort(403);
        }

        // No permitir eliminar admin primario
        if ($user->rol === 'admin_primario') {
            return back()->with('error', 'No puedes eliminar el administrador principal.');
        }

        // No permitir auto eliminarse
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return back()->with('success', 'Administrador eliminado correctamente.');
    }
}