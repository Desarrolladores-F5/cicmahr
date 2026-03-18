<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Solicitudes de Vacaciones</h1>

        <div class="bg-white shadow rounded-xl p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Trabajador</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Días</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vacaciones as $vacacion)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $vacacion->trabajador->nombre ?? 'Sin nombre' }}
                            </td>
                            <td>{{ $vacacion->fecha_inicio }}</td>
                            <td>{{ $vacacion->fecha_fin }}</td>
                            <td>{{ $vacacion->dias_solicitados }}</td>
                            <td>
                                <span class="px-2 py-1 rounded text-sm
                                    @if($vacacion->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($vacacion->estado == 'aprobado') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ $vacacion->estado }}
                                </span>
                            </td>

                            <td class="space-x-2">
                                <button class="bg-green-500 text-white px-3 py-1 rounded">
                                    Aprobar
                                </button>

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Rechazar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>