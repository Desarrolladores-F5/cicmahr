<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Solicitar Vacaciones</h1>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

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
    </div>
</x-app-layout>