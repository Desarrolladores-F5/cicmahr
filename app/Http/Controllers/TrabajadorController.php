<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrabajadorController extends Controller   // 🔥 NUEVO CONTROLADOR PARA GESTIONAR TRABAJADORES
{
    public function create()
    {
        return view('admin.trabajadores.create');
    }

    public function store(Request $request)
    {
        $empresa = auth()->user()->empresa;

        $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'rut' => 'required|string|max:20|unique:trabajadores,rut,NULL,id,empresa_id,' . $empresa->id,
            'email' => 'required|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:150',
            'sueldo' => 'nullable|numeric|min:0',
            'tipo_contrato' => 'nullable|in:plazo_fijo,indefinido',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'horario' => 'nullable|string|max:150',
            'horas_semanales' => 'required|integer|min:1|max:42',
            'estado' => 'required|in:vigente,no_vigente',
        ]);

        // 🔥 VALIDACIÓN DE PLAN
        if (!$empresa->puedeAgregarTrabajador()) {
            return redirect()
                ->back()
                ->with('error', 'Has alcanzado el límite de trabajadores de tu plan.');
        }

        // Normalizar RUT
        $rut = strtoupper(trim($request->rut));
        $rut = str_replace('.', '', $rut);

        // 1️⃣ Crear trabajador
        $trabajador = Trabajador::create([
            'empresa_id' => $empresa->id,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'rut' => $rut,
            'direccion' => $request->direccion,
            'email_contacto' => $request->email,
            'cargo' => $request->cargo,
            'sueldo' => $request->sueldo,
            'tipo_contrato' => $request->tipo_contrato,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_salida' => $request->fecha_salida,
            'horario' => $request->horario,
            'horas_semanales' => $request->horas_semanales,
            'estado' => $request->estado,
        ]);
        
        // 2️⃣ Registrar actividad para el log de auditoría
        registrarActividad(
            'trabajadores',
            'crear',
            'Se creó el trabajador: ' . $trabajador->nombre . ' ' . $trabajador->apellido . ' (RUT: ' . $trabajador->rut . ')'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Trabajador registrado correctamente.');
    }

    public function index(Request $request)   // 🔥 NUEVO MÉTODO PARA LISTAR LOS TRABAJADORES CON FILTROS DE BÚSQUEDA
    {
        $empresaId = auth()->user()->empresa_id;

        $query = Trabajador::where('empresa_id', $empresaId)->where('estado', 'vigente');
                            

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->where('rut', 'like', "%{$buscar}%")
                ->orWhere('nombre', 'like', "%{$buscar}%")
                ->orWhere('apellido', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        $trabajadores = $query
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('trabajadores.index', compact('trabajadores'));
    }

    public function edit(Trabajador $trabajador)    // 🔥 NUEVO MÉTODO PARA MOSTRAR EL FORMULARIO DE EDICIÓN DE UN TRABAJADOR
    {
        // Seguridad: evitar que editen trabajador de otra empresa
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $tiposDocumento = TipoDocumento::orderBy('nombre_documento')->get();

        $documentos = $trabajador->documentos()
            ->with('tipoDocumento')
            ->orderByDesc('fecha_documento')
            ->orderByDesc('created_at')
            ->get();

        return view('trabajadores.edit', compact('trabajador', 'tiposDocumento', 'documentos'));
    }

    public function update(Request $request, Trabajador $trabajador)  // 🔥 NUEVO MÉTODO PARA ACTUALIZAR LOS DATOS DE UN TRABAJADOR
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $request->validate([                          //Fíjate que NO incluimos RUT en validación porque no lo vamos a modificar nunca, es un id.
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'direccion' => 'nullable|string|max:255',
            'cargo' => 'nullable|string|max:150',
            'sueldo' => 'nullable|numeric',
            'tipo_contrato' => 'nullable|in:plazo_fijo,indefinido',
            'fecha_ingreso' => 'nullable|date',
            'fecha_salida' => 'nullable|date',
            'estado' => 'required|in:vigente,no_vigente',
            'horario' => 'nullable|string|max:150',
            'horas_semanales' => 'required|integer|min:1|max:42',
        ]);

        // Lógica de contratos inteligente, aunque alguien manipule el HTML, el backend lo corrige.
        $data = $request->except(['_token', '_method']);

        if ($request->tipo_contrato === 'indefinido') {
            $data['fecha_salida'] = null;
        }

        $original = $trabajador->getOriginal();

        $trabajador->update($data);

        $cambios = [];

        foreach ($data as $campo => $valor) {
            if (array_key_exists($campo, $original) && $original[$campo] != $valor) {

                $nombreCampo = str_replace('_', ' ', ucfirst($campo));

                $cambios[] = $nombreCampo . ': ' . ($original[$campo] ?? 'null') . ' → ' . ($valor ?? 'null');
            }
        }

        if (!empty($cambios)) {
            registrarActividad(
                'trabajadores',
                'editar',
                'Se editó el trabajador ' . $trabajador->nombre . ' ' . $trabajador->apellido .
                ' (RUT: ' . $trabajador->rut . '). Cambios: ' . implode(', ', $cambios)
            );
        }

        return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    public function inactivos()// 🔥 NUEVO MÉTODO PARA MOSTRAR LOS TRABAJADORES INACTIVOS (CESADOS O SUSPENDIDOS) DESDE EL DASHBOARD DEL ADMIN
    {
        $empresaId = auth()->user()->empresa_id;

        $trabajadores = Trabajador::where('empresa_id', $empresaId)
            ->where('estado', 'no_vigente')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('trabajadores.inactivos', compact('trabajadores'));
    }

    public function reactivar(Trabajador $trabajador)  // 🔥 MÉTODO PARA REACTIVAR UN TRABAJADOR INACTIVO DESDE EL DASHBOARD DEL ADMIN
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        // 🧠 Guardamos estado anterior
        $estadoAnterior = $trabajador->estado;

        $trabajador->update([
            'estado' => 'vigente'
        ]);
        
        // 🔥 Auditoría
        registrarActividad(
            'trabajadores',
            'reactivar',
            'Se reactivó el trabajador ' . $trabajador->nombre . ' ' . $trabajador->apellido .
            ' (RUT: ' . $trabajador->rut . '). Estado: ' . $estadoAnterior . ' → vigente'
        );

        return redirect()->route('trabajadores.inactivos')
            ->with('success', 'Trabajador reactivado correctamente.');
    }

    public function inactivar(Trabajador $trabajador)         // 🔥 Es una Acción, ambia el estado de un trabajador a no_vigente
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $estadoAnterior = $trabajador->estado;

        $trabajador->update([
            'estado' => 'no_vigente'
        ]);

        registrarActividad(
            'trabajadores',
            'inactivar',
            'Se marcó como inactivo al trabajador ' . $trabajador->nombre . ' ' . $trabajador->apellido .
            ' (RUT: ' . $trabajador->rut . '). Estado: ' . $estadoAnterior . ' → no_vigente'
        );

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador marcado como no vigente.');
    }


    public function eliminarDefinitivo(Trabajador $trabajador)
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        if ($trabajador->estado !== 'no_vigente') {
            abort(403);
        }

        // 🧠 Guardamos datos antes de eliminar
        $nombreCompleto = $trabajador->nombre . ' ' . $trabajador->apellido;
        $rut = $trabajador->rut;

        // 👤 Eliminar usuario asociado (si existe)
        if ($trabajador->user_id) {
            $trabajador->user()->delete();
        }

        // 💀 Eliminamos trabajador
        $trabajador->delete();

        // 🔥 Auditoría (DESPUÉS de eliminar, pero con datos guardados)
        registrarActividad(
            'trabajadores',
            'eliminar',
            'Se eliminó definitivamente al trabajador ' . $nombreCompleto . ' (RUT: ' . $rut . ')'
        );

        return redirect()->route('trabajadores.inactivos')
            ->with('success', 'Trabajador eliminado definitivamente.');
    }

    public function guardarAcceso(Request $request, Trabajador $trabajador)
    {
        // Seguridad: mismo tenant
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        $empresaId = auth()->user()->empresa_id;

        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Validar email único por empresa (excluyendo el user actual si existe)
        $query = User::where('empresa_id', $empresaId)
            ->where('email', $request->email);

        if ($trabajador->user_id) {
            $query->where('id', '!=', $trabajador->user_id);
        }

        if ($query->exists()) {
            return back()
                ->withErrors(['email' => 'Este correo ya está registrado en la empresa.'])
                ->withInput();
        }

        // Si NO tiene user, lo creamos
        if (!$trabajador->user_id) {
            $passwordTemporal = Str::random(8);

            // Verificar si el correo ya existe
            $usuarioExistente = User::where('email', $request->email)->first();

            if ($usuarioExistente) {

                return redirect()
                    ->back()
                    ->with('error', '⚠️ Este correo ya tiene acceso registrado en CicmaHR.');
            }

            $user = User::create([
                'name' => $trabajador->nombre . ' ' . $trabajador->apellido,
                'email' => $request->email,
                'password' => Hash::make($passwordTemporal),
                'empresa_id' => $empresaId,
                'rol' => 'trabajador',
                'estado' => 'activo',
                'must_change_password' => true,
            ]);

            $trabajador->update(['user_id' => $user->id]);

            return back()->with('portal_success', "Acceso creado. Contraseña temporal: {$passwordTemporal}");
        }

        // Si YA tiene user, actualizamos el correo
        $user = User::where('empresa_id', $empresaId)->findOrFail($trabajador->user_id);
        $user->update(['email' => $request->email]);

        return back()->with('portal_success', 'Correo de acceso actualizado correctamente.');
    }

    public function resetPassword(Trabajador $trabajador)  // 🔥 NUEVO MÉTODO PARA RESETEAR LA CONTRASEÑA DE UN TRABAJADOR
    {
        if ($trabajador->empresa_id !== auth()->user()->empresa_id) {
            abort(403);
        }

        if (!$trabajador->user_id) {
            return back()->withErrors(['email' => 'Este trabajador aún no tiene acceso al portal.']);
        }

        $user = \App\Models\User::findOrFail($trabajador->user_id);

        $passwordTemporal = Str::random(8);

        $user->update([
            'password' => Hash::make($passwordTemporal),
            'must_change_password' => true,
        ]);

        return back()->with('portal_success', "Nueva contraseña temporal: {$passwordTemporal}");
    }
}