<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()    // para listar administradores de la empresa
    {
        $empresa = auth()->user()->empresa;

        $administradores = $empresa->users()
            ->whereIn('rol', ['admin_primario', 'admin_secundario'])
            ->orderBy('rol') // primario arriba
            ->get();

        $limite = $empresa->limiteAdministradores();

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'administradores',
            'visita',
            'Se visualizó el listado de administradores de la empresa'
        );

        return view('admin.administradores.index', compact('administradores', 'limite'));
    }

    public function create()    // para mostrar formulario de creación de administrador secundario
    {
        $empresa = auth()->user()->empresa;

        if (!$empresa->puedeAgregarAdministrador()) {
            return redirect()
                ->route('admin.administradores.index')
                ->with('error', 'Has alcanzado el límite de administradores de tu plan.');
        }

        return view('admin.administradores.create');
    }


    public function store(Request $request)   // para guardar nuevo administrador secundario
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $empresa->id,
            'rol' => 'admin_secundario',
            'estado' => 'activo',
            'must_change_password' => true, // para que cambie al entrar
        ]);

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'administradores',
            'crear',
            'Se creó un administrador secundario: ' . $user->name . ' (' . $user->email . ')'
        );

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

        $nombre = $user->name;
        $email = $user->email;

        $user->delete();

        // 🔥 AUDITORÍA PARA HISTORIAL DE REGISTRO
        registrarActividad(
            'administradores',
            'eliminar',
            'Se eliminó el administrador: ' . $nombre . ' (' . $email . ')'
        );

        return back()->with('success', 'Administrador eliminado correctamente.');
    }
}