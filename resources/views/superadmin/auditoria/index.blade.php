@extends('layouts.superadmin')

@section('content')

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Auditoría Global
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Registro completo de actividad dentro de CicmaHR.
                </p>
            </div>

            <div class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                {{ $actividades->total() }} registros
            </div>

        </div>

        {{-- TABLA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>
                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Fecha
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Usuario
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Empresa
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Módulo
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Acción
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Descripción
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                IP
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($actividades as $actividad)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $actividad->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-900">
                                        {{ $actividad->user->name ?? 'Sistema' }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        {{ $actividad->user->email ?? '-' }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-gray-700">

                                    {{ $actividad->user->empresa->nombre ?? 'SuperAdmin' }}

                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">
                                        {{ ucfirst($actividad->modulo) }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    @if($actividad->accion === 'crear')

                                        <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">
                                            Crear
                                        </span>

                                    @elseif($actividad->accion === 'editar')

                                        <span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-semibold">
                                            Editar
                                        </span>

                                    @elseif($actividad->accion === 'eliminar')

                                        <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-semibold">
                                            Eliminar
                                        </span>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-3 py-1 text-xs font-semibold">
                                            {{ ucfirst($actividad->accion) }}
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4 text-gray-700 max-w-lg">
                                    {{ $actividad->descripcion }}
                                </td>

                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $actividad->ip ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    No existen registros de auditoría.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINACIÓN --}}
        <div>
            {{ $actividades->links() }}
        </div>

    </div>

@endsection