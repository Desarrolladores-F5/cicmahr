<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse   // 👈 método store para redirigir a diferentes dashboards según el rol del usuario
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if ($user->rol === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        if (in_array($user->rol, ['admin_primario', 'admin_secundario'])) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->rol === 'trabajador') {
            return redirect()->route('worker.dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}