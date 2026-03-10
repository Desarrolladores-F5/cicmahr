<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Carga Masiva de Documentos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">

                @if(session('success'))
                    <div class="rounded-lg bg-green-50 p-3 text-green-800 border border-green-200 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-lg bg-red-50 p-3 text-red-800 border border-red-200 mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.documentos.carga.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Seleccionar PDFs o ZIP
                        </label>

                        <input type="file"
                               name="archivos[]"
                               multiple
                               class="w-full border rounded-lg p-2">
                        <p class="text-xs text-gray-500 mt-1">
                            Puedes seleccionar varios PDFs, o un ZIP (si lo soporta tu controlador).
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                            Procesar archivos
                        </button>

                        <a href="{{ route('admin.dashboard') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                            Volver
                        </a>
                    </div>

                </form>

                <div class="mt-6 bg-blue-50 border border-blue-200 p-4 rounded-lg text-sm text-blue-800">

                    <strong>💡 Consejo para carga masiva</strong>

                    <p class="mt-2">
                        Los documentos deben incluir el RUT del trabajador en el nombre del archivo.
                    </p>

                    <p class="mt-2">
                        Ejemplo:
                    </p>

                    <ul class="list-disc ml-5 mt-2">
                        <li>12345678-9_03_2026_liquidacion.pdf</li>
                        <li>98765432-K_03_2026_liquidacion.pdf</li>
                    </ul>

                    <p class="mt-2">
                            Puedes subir:
                    </p>

                    <ul class="list-disc ml-5">
                        <li>Múltiples PDFs</li>
                        <li>Un archivo ZIP con todos los PDFs</li>
                    </ul>

                </div>

                <p class="text-sm text-gray-500 mt-6">
                    Formato recomendado de nombre de archivo:<br>
                    <strong>12345678-9_03_2026_liquidacion.pdf</strong>
                </p>

            </div>

        </div>
    </div>
</x-app-layout>