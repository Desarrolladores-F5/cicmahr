<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de Actividad
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl overflow-hidden">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Usuario</th>
                            <th class="px-6 py-3 text-left">Módulo</th>
                            <th class="px-6 py-3 text-left">Acción</th>
                            <th class="px-6 py-3 text-left">Descripción</th>
                            <th class="px-6 py-3 text-left">Fecha</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse($actividades as $actividad)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    {{ $actividad->user->name ?? 'Sistema' }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ ucfirst($actividad->modulo) }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $accion = trim(strtolower($actividad->accion));
                                    @endphp

                                    @if($accion === 'crear')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                            Crear
                                        </span>

                                    @elseif($accion === 'editar')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">
                                            Editar
                                        </span>

                                    @elseif($accion === 'eliminar')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                                            Eliminar
                                        </span>

                                    @elseif($accion === 'aprobar')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                            Aprobar
                                        </span>

                                    @elseif($accion === 'rechazar')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                                            Rechazar
                                        </span>

                                    @elseif($accion === 'reactivar')
                                        <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-medium">
                                            Reactivar
                                        </span>

                                    @elseif($accion === 'inactivar')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                                            Inactivar
                                        </span>

                                    @elseif($accion === 'visita')
                                        <span class="bg-yellow-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">
                                            Visita
                                        </span>

                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                            {{ ucfirst($accion) }}
                                        </span>
                                    @endif
                                </td>


                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $actividad->descripcion }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $actividad->created_at->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    No hay actividad registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $actividades->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>