<x-app-layout>

    <div class="max-w-7xl mx-auto py-8 px-6">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                🏖️ Solicitudes de Vacaciones
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Revisa, aprueba o rechaza las solicitudes realizadas por los trabajadores.
            </p>
        </div>

        <div class="bg-white shadow-md border border-gray-100 rounded-3xl overflow-hidden">

            <table class="min-w-full divide-y divide-gray-100">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Trabajador
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Periodo
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Días
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

                    @forelse ($vacaciones as $vacacion)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Trabajador --}}
                            <td class="px-6 py-5">
                                <div class="font-semibold text-gray-900">
                                    👤 {{ $vacacion->trabajador->nombre ?? 'Sin nombre' }}
                                    {{ $vacacion->trabajador->apellido ?? '' }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    Solicitud de vacaciones
                                </div>
                            </td>

                            {{-- Periodo --}}
                            <td class="px-6 py-5">
                                <div class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($vacacion->fecha_inicio)->format('d-m-Y') }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    hasta {{ \Carbon\Carbon::parse($vacacion->fecha_fin)->format('d-m-Y') }}
                                </div>
                            </td>

                            {{-- Días --}}
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $vacacion->dias_solicitados }} día(s)
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-5">
                                @if($vacacion->estado == 'pendiente')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        ⏳ Pendiente
                                    </span>
                                @elseif($vacacion->estado == 'aprobado')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        ✅ Aprobado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        ❌ Rechazado
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-5 text-right">

                                @if($vacacion->estado === 'pendiente')

                                    <div class="space-y-3">

                                        <form action="{{ route('admin.vacaciones.aprobar', $vacacion) }}"
                                              method="POST"
                                              class="flex justify-end gap-2">
                                            @csrf

                                            <input
                                                type="text"
                                                name="comentario_admin"
                                                placeholder="Comentario opcional"
                                                class="w-56 rounded-xl border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            >

                                            <button
                                                type="submit"
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold hover:bg-emerald-100 transition">
                                                ✅ Aprobar
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.vacaciones.rechazar', $vacacion) }}"
                                              method="POST"
                                              class="flex justify-end gap-2">
                                            @csrf

                                            <input
                                                type="text"
                                                name="comentario_admin"
                                                placeholder="Motivo rechazo"
                                                class="w-56 rounded-xl border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            >

                                            <button
                                                type="submit"
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 transition">
                                                ❌ Rechazar
                                            </button>
                                        </form>

                                    </div>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm font-semibold">
                                        🔒 Procesado
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="text-5xl mb-4">
                                    📭
                                </div>

                                <p class="font-semibold text-gray-800">
                                    No hay solicitudes de vacaciones
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Cuando un trabajador solicite vacaciones aparecerán aquí.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>