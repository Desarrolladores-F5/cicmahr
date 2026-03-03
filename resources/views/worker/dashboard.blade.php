@extends('layouts.worker')

@section('content')

<div class="bg-white shadow rounded-xl p-6">
    <h3 class="text-lg font-semibold mb-2">
        Bienvenido, {{ Auth::user()->name }}
    </h3>

    <p class="text-gray-600">
        Aquí podrás revisar tus documentos laborales,
        contratos y estado de certificaciones.
    </p>

    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
        <p class="text-sm text-gray-500">
            Empresa: {{ Auth::user()->empresa?->nombre }}
        </p>
        <p class="text-sm text-gray-500">
            Rol: {{ Auth::user()->rol }}
        </p>
    </div>
</div>

@endsection