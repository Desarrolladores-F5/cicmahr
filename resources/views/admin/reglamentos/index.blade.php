<x-app-layout>
    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                📚 Reglamentos Internos
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Administra y distribuye reglamentos y documentos oficiales de la empresa.
            </p>

        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">
                <div class="flex items-center gap-3 mb-6">

                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl">
                        📤
                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Subir nuevo reglamento
                        </h3>

                        <p class="text-sm text-gray-500">
                            Publica documentos oficiales para todos los trabajadores.
                        </p>

                    </div>

                </div>

                <div class="border-t pt-6"></div>

                <form action="{{ route('admin.reglamentos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                        <input type="number" name="anio" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                        <input type="file" name="archivo" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg transition">
                        Subir reglamento
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">
                <div class="flex items-center gap-3 mb-6">

                    <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-2xl">
                        📂
                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Reglamentos disponibles
                        </h3>

                        <p class="text-sm text-gray-500">
                            Historial de reglamentos cargados para la empresa.
                        </p>

                    </div>

                </div>

                <div class="border-t pt-6"></div>

                @if($reglamentos->isEmpty())
                    <p class="text-gray-500">Aún no hay reglamentos cargados.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-600 border-b">
                                    <th class="p-3">Nombre</th>                                    
                                    <th class="p-3">Descripción</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reglamentos as $reglamento)
                                    <tr class="border-b">
                                        <td class="p-4">

                                            <div class="font-semibold text-gray-900">
                                                {{ $reglamento->nombre }}
                                            </div>

                                            <div class="text-sm text-gray-500 mt-1">
                                                Año {{ $reglamento->anio }}
                                            </div>

                                        </td>
                                        <td class="p-3">{{ $reglamento->descripcion ?: '—' }}</td>
                                        <td class="p-3">
                                            <a href="{{ route('admin.reglamentos.download', $reglamento) }}"
                                               class="text-blue-600 hover:underline">
                                                Descargar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>