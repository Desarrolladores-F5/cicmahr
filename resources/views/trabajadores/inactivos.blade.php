<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trabajadores Inactivos
            </h2>
            <span class="text-sm bg-red-50 text-red-700 px-3 py-1 rounded-full">
                Total: {{ $trabajadores->count() }}
            </span>

            <a href="{{ route('trabajadores.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                ← Volver a Vigentes
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">RUT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th> 
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($trabajadores as $trabajador)
                            <tr>
                                <td class="px-6 py-4">
                                    {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trabajador->rut }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $trabajador->cargo ?: '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($trabajador->estado === 'no_vigente')
                                        <span class="inline-flex items-center bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                            No vigente
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            Vigente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center space-x-3">

                                    {{-- Reactivar --}}
                                    <form method="POST"
                                        action="{{ route('trabajadores.reactivar', $trabajador) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="text-green-600 hover:underline">
                                            Reactivar
                                        </button>
                                    </form>

                                    {{-- Eliminar definitivo --}}
                                    <form method="POST"
                                        action="{{ route('trabajadores.eliminarDefinitivo', $trabajador) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Eliminar definitivamente este trabajador? Esta acción no se puede deshacer.')"
                                                class="text-red-600 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No hay trabajadores inactivos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>