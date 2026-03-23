<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Solicitar Vacaciones</h1>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORMULARIO -->
        <div class="bg-white shadow rounded-xl p-6">
            <form action="{{ route('worker.vacaciones.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de inicio
                    </label>
                    <input type="date" name="fecha_inicio" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de fin
                    </label>
                    <input type="date" name="fecha_fin" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Comentario
                    </label>
                    <textarea name="comentario" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2"
                        placeholder="Ej: Viaje familiar"></textarea>
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Enviar solicitud
                </button>
            </form>
        </div>

        <!-- HISTORIAL -->
        <div class="bg-white shadow rounded-xl p-6 mt-8">

        <h2 class="text-lg font-semibold mb-4 mt-2">
            Historial de solicitudes
        </h2>

        @if($vacaciones->isEmpty())
            <p class="text-gray-500">Aún no has solicitado vacaciones.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-xl shadow-sm">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 border-b">
                            <th class="p-3">Inicio</th>
                            <th class="p-3">Fin</th>
                            <th class="p-3">Días</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3">Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacaciones as $vacacion)
                            <tr class="border-b">
                                <td class="p-3">{{ $vacacion->fecha_inicio }}</td>
                                <td class="p-3">{{ $vacacion->fecha_fin }}</td>
                                <td class="p-3">{{ $vacacion->dias_solicitados }}</td>
                                <td class="p-3">
                                    @if($vacacion->estado === 'pendiente')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Pendiente</span>
                                    @elseif($vacacion->estado === 'aprobado')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Aprobado</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Rechazado</span>
                                    @endif

                                    @if($vacacion->comentario_admin)
                                        <div class="text-xs text-gray-500 mt-1 italic">
                                            Motivo: {{ $vacacion->comentario_admin }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3">
                                    {{ $vacacion->fecha_respuesta ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-app-layout>