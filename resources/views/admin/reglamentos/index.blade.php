<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reglamentos Internos
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Subir nuevo reglamento</h3>

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
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Subir reglamento
                    </button>
                </form>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Reglamentos cargados</h3>

                @if($reglamentos->isEmpty())
                    <p class="text-gray-500">Aún no hay reglamentos cargados.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-600 border-b">
                                    <th class="p-3">Nombre</th>
                                    <th class="p-3">Año</th>
                                    <th class="p-3">Descripción</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reglamentos as $reglamento)
                                    <tr class="border-b">
                                        <td class="p-3">{{ $reglamento->nombre }}</td>
                                        <td class="p-3">{{ $reglamento->anio }}</td>
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