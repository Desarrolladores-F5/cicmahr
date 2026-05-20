<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::withCount('trabajadores')
            ->latest()
            ->paginate(10);

        return view('superadmin.empresas.index', compact('empresas'));
    }

    public function show(Empresa $empresa)
    {
        $empresa->load([
            'trabajadores',
            'users',
            'pagos'
        ]);

        return view('superadmin.empresas.show', compact('empresa'));
    }

    public function entrar(Empresa $empresa)
    {
        // Buscar admin principal empresa
        $admin = $empresa->users()
            ->where('rol', 'admin_primario')
            ->first();

        if (!$admin) {
            return back()->with('error', 'La empresa no tiene administrador principal.');
        }

        // Guardar superadmin original
        session([
            'superadmin_id' => auth()->id(),
        ]);

        // Registrar actividad de impersonación
        registrarActividad(
            'superadmin',
            'impersonacion',
            'SuperAdmin ingresó como administrador de: ' . $empresa->nombre
        );

        // Login como empresa
        auth()->login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Entraste como administrador de la empresa.');
    }

    public function volver()             // Permite al superadmin volver a su sesión original después de haber entrado como empresa
    {
        // Obtener ID original del superadmin
        $superadminId = session('superadmin_id');

        if (!$superadminId) {
            return redirect('/')
                ->with('error', 'No hay sesión SuperAdmin activa.');
        }

        // Buscar usuario original
        $superadmin = \App\Models\User::find($superadminId);

        if (!$superadmin) {
            return redirect('/')
                ->with('error', 'SuperAdmin no encontrado.');
        }

        // Restaurar sesión original
        auth()->login($superadmin);

        // Limpiar sesión temporal
        session()->forget('superadmin_id');

         // Registrar auditoría
        registrarActividad(
            'superadmin',
            'volver',
            'SuperAdmin volvió a su sesión original'
        );

        return redirect()
            ->route('superadmin.dashboard')
            ->with('success', 'Volviste al panel SuperAdmin.');
    }

    public function suspender(Empresa $empresa)        // Permite al superadmin suspender una empresa.
    {
        $empresa->update([
            'estado' => 'suspendida'
        ]);

        registrarActividad(
            'superadmin',
            'suspender',
            'Se suspendió la empresa: ' . $empresa->nombre
        );

        return back()->with(
            'success',
            'Empresa suspendida correctamente.'
        );
    }

    public function reactivar(Empresa $empresa)           // Permite al superadmin reactivar una empresa que ha sido suspendida.
    {
        $empresa->update([
            'estado' => 'activa'
        ]);

        registrarActividad(
            'superadmin',
            'reactivar',
            'Se reactivó la empresa: ' . $empresa->nombre
        );

        return back()->with(
            'success',
            'Empresa reactivada correctamente.'
        );
    }

    public function editRut(Empresa $empresa)
    {
        return view('superadmin.empresas.edit-rut', compact('empresa'));
    }

    public function updateRut(Request $request, Empresa $empresa)
    {
        $request->validate([
            'rut' => 'required|string|max:20|unique:empresas,rut,' . $empresa->id,
        ]);

        $rut = strtoupper(trim($request->rut));
        $rut = str_replace('.', '', $rut);

        $empresa->update([
            'rut' => $rut,
        ]);

        registrarActividad(
            'superadmin',
            'editar',
            'Se actualizó el RUT de la empresa: ' . $empresa->nombre
        );

        return redirect()
            ->route('superadmin.empresas.show', $empresa)
            ->with('success', 'RUT de empresa actualizado correctamente.');
    }

    public function editRutTrabajador(Trabajador $trabajador)
    {
        return view('superadmin.empresas.edit-rut-trabajador', compact('trabajador'));
    }

    public function updateRutTrabajador(Request $request, Trabajador $trabajador)
    {
        $request->validate([
            'rut' => 'required|string|max:20|unique:trabajadores,rut,' . $trabajador->id,
        ]);

        $rut = strtoupper(trim($request->rut));
        $rut = str_replace('.', '', $rut);

        $trabajador->update([
            'rut' => $rut,
        ]);

        registrarActividad(
            'superadmin',
            'editar',
            'Se actualizó el RUT del trabajador: '
            . $trabajador->nombre . ' ' . $trabajador->apellido
        );

        return redirect()
            ->route('superadmin.empresas.show', $trabajador->empresa)
            ->with('success', 'RUT del trabajador actualizado correctamente.');
    }
}