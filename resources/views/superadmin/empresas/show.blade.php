@extends('layouts.superadmin')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $empresa->nombre }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ficha global de empresa dentro de CicmaHR.
            </p>
        </div>

        <a href="{{ route('superadmin.empresas.index') }}"
           class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
            Volver
        </a>
    </div>

    {{-- CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <p class="text-sm text-gray-500">Plan</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">
                {{ ucfirst($empresa->plan) }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <p class="text-sm text-gray-500">Estado</p>
            <p class="text-2xl font-bold mt-2 {{ $empresa->estado === 'activa' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($empresa->estado) }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <p class="text-sm text-gray-500">Trabajadores</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">
                {{ $empresa->trabajadores->count() }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <p class="text-sm text-gray-500">Pagos</p>
            <p class="text-2xl font-bold text-indigo-600 mt-2">
                {{ $empresa->pagos->count() }}
            </p>
        </div>

    </div>

    {{-- DATOS EMPRESA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
            Datos de la empresa
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

            <p><strong>Nombre:</strong> {{ $empresa->nombre }}</p>
            <p><strong>RUT:</strong> {{ $empresa->rut }}</p>
            <p><strong>Giro:</strong> {{ $empresa->giro ?? '-' }}</p>
            <p><strong>Dirección:</strong> {{ $empresa->direccion ?? '-' }}</p>
            <p><strong>Trial hasta:</strong> {{ optional($empresa->trial_hasta)->format('d-m-Y') ?? '-' }}</p>
            <p><strong>Suscripción activa:</strong> {{ $empresa->suscripcion_activa ? 'Sí' : 'No' }}</p>

        </div>
    </div>

    {{-- USUARIOS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
            Usuarios administradores
        </h2>

        <table class="min-w-full text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-3 text-gray-500">Nombre</th>
                    <th class="text-left py-3 px-3 text-gray-500">Email</th>
                    <th class="text-left py-3 px-3 text-gray-500">Rol</th>
                    <th class="text-left py-3 px-3 text-gray-500">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresa->users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-3 font-medium">{{ $user->name }}</td>
                        <td class="py-3 px-3">{{ $user->email }}</td>
                        <td class="py-3 px-3">{{ $user->rol }}</td>
                        <td class="py-3 px-3">{{ $user->estado ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ÚLTIMOS PAGOS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">
            Últimos pagos
        </h2>

        <table class="min-w-full text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-3 text-gray-500">Orden</th>
                    <th class="text-left py-3 px-3 text-gray-500">Monto</th>
                    <th class="text-left py-3 px-3 text-gray-500">Estado</th>
                    <th class="text-left py-3 px-3 text-gray-500">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresa->pagos->sortByDesc('created_at')->take(5) as $pago)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-3">{{ $pago->orden }}</td>
                        <td class="py-3 px-3">${{ number_format($pago->monto, 0, ',', '.') }}</td>
                        <td class="py-3 px-3">{{ ucfirst($pago->estado) }}</td>
                        <td class="py-3 px-3">{{ optional($pago->fecha_pago)->format('d-m-Y H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">
                            No hay pagos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection