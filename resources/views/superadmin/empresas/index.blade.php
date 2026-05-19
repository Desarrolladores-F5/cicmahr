@extends('layouts.superadmin')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Empresas registradas
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Gestión global de empresas dentro de CicmaHR.
            </p>
        </div>

        <div class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-semibold">
            Total: {{ $empresas->total() }}
        </div>

    </div>

    {{-- TABLA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>
                        <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                            Empresa
                        </th>

                        <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                            Plan
                        </th>

                        <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                            Trabajadores
                        </th>

                        <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                            Creada
                        </th>

                        <th class="px-6 py-4 text-right text-gray-500 font-semibold">
                            Acciones
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($empresas as $empresa)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-900">
                                    {{ $empresa->nombre }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $empresa->rut }}
                                </div>

                            </td>

                            <td class="px-6 py-4">

                                <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">
                                    {{ ucfirst($empresa->plan) }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                @if($empresa->estado === 'activa')

                                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">
                                        Activa
                                    </span>

                                @elseif($empresa->estado === 'suspendida')

                                    <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-semibold">
                                        Suspendida
                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-semibold">
                                        Trial
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $empresa->trabajadores_count }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $empresa->created_at->format('d-m-Y') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('superadmin.empresas.show', $empresa) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg transition">
                                        Ver
                                    </a>

                                    @if($empresa->estado === 'activa')

                                        <form action="{{ route('superadmin.empresas.suspender', $empresa) }}"
                                            method="POST">

                                            @csrf

                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white text-xs px-4 py-2 rounded-lg transition">
                                                Suspender
                                            </button>

                                        </form>

                                    @else

                                        <form action="{{ route('superadmin.empresas.reactivar', $empresa) }}"
                                            method="POST">

                                            @csrf

                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg transition">
                                                Reactivar
                                            </button>

                                        </form>

                                    @endif


                                    <form action="{{ route('superadmin.empresas.entrar', $empresa) }}"
                                        method="POST">

                                        @csrf

                                        <button type="submit"
                                            class="bg-gray-900 hover:bg-gray-800 text-white text-xs px-4 py-2 rounded-lg transition">
                                            Entrar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                No hay empresas registradas.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINACIÓN --}}
    <div>
        {{ $empresas->links() }}
    </div>

</div>

@endsection