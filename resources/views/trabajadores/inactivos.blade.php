<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-3">
                    📦 Trabajadores Inactivos
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Revisa trabajadores desvinculados o no vigentes de la empresa.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <span class="text-sm font-semibold bg-amber-50 text-amber-700 px-4 py-2 rounded-full">
                    Total: {{ $trabajadores->count() }}
                </span>

                <a href="{{ route('trabajadores.index') }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl font-semibold transition">
                    ← Volver a Vigentes
                </a>

            </div>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl overflow-hidden">

                <table class="min-w-full divide-y divide-gray-100">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Trabajador
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Cargo
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">

                        @forelse($trabajadores as $trabajador)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- Trabajador --}}
                                <td class="px-6 py-5">

                                    <div class="font-semibold text-gray-900">
                                        👤 {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                                    </div>

                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $trabajador->rut }}
                                    </div>

                                </td>

                                {{-- Cargo --}}
                                <td class="px-6 py-5">

                                    @if($trabajador->cargo)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ $trabajador->cargo }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">
                                            Sin cargo
                                        </span>
                                    @endif

                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-5">

                                    @if($trabajador->estado === 'no_vigente')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            🔴 No vigente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            🟢 Vigente
                                        </span>
                                    @endif

                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-5 text-right whitespace-nowrap">

                                    <div class="inline-flex items-center gap-2">

                                        {{-- Reactivar --}}
                                        <form method="POST"
                                              action="{{ route('trabajadores.reactivar', $trabajador) }}"
                                              class="inline">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold hover:bg-emerald-100 transition">
                                                ♻️ Reactivar
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
                                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 transition">
                                                🗑 Eliminar
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">

                                    <div class="text-5xl mb-4">
                                        📭
                                    </div>

                                    <p class="font-semibold text-gray-800">
                                        No hay trabajadores inactivos
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Cuando un trabajador sea marcado como no vigente aparecerá aquí.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>