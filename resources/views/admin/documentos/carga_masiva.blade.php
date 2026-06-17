<x-app-layout>
    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    📦 Carga Masiva de Documentos
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Procesa múltiples documentos automáticamente utilizando el RUT del trabajador.
                </p>

            </div>

        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 space-y-8">

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

                        <div class="flex items-center gap-3 mb-4">

                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl">
                                📄
                            </div>

                            <div>

                                <h3 class="text-xl font-bold text-gray-900">
                                    Seleccionar archivos
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Puedes subir múltiples PDFs o un archivo ZIP.
                                </p>

                            </div>

                        </div>

                        <div class="border-t pt-6">

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Archivos a procesar
                            </label>

                            <input type="file"
                                name="archivos[]"
                                multiple
                                class="w-full border rounded-xl p-3">

                            <p class="text-xs text-gray-500 mt-2">
                                Puedes seleccionar varios PDFs o un archivo ZIP.
                            </p>

                        </div>

                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg transition">
                            ⚡ Procesar archivos
                        </button>

                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                                ← Volver
                        </a>
                    </div>

                </form>

                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 rounded-3xl p-8">

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-white shadow flex items-center justify-center text-2xl">
                            💡
                        </div>

                        <div>

                            <h3 class="text-2xl font-bold text-indigo-900">
                                Centro de Ayuda
                            </h3>

                            <p class="text-sm text-indigo-700">
                                Recomendaciones para procesar documentos correctamente.
                            </p>

                        </div>

                    </div>


                    <div class="grid md:grid-cols-2 gap-8">

                        {{-- Columna izquierda --}}
                        <div>

                            <h4 class="font-semibold text-gray-800 mb-3">
                                📄 Formato de nombre recomendado
                            </h4>

                            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">

                                <div class="text-gray-500 text-sm mb-2">
                                    Ejemplo
                                </div>

                                <div class="font-bold text-gray-900">
                                    12345678-9_03_2026_liquidacion.pdf
                                </div>

                            </div>

                            <div class="mt-4 text-sm text-gray-600">
                                El RUT del trabajador debe formar parte del nombre del archivo.
                            </div>

                        </div>


                        {{-- Columna derecha --}}
                        <div>

                            <h4 class="font-semibold text-gray-800 mb-3">
                                📦 Archivos permitidos
                            </h4>

                            <div class="space-y-3">

                                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">

                                    ✅ Múltiples archivos PDF.

                                </div>

                                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">

                                    ✅ Un archivo ZIP con todos los documentos.

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                

            </div>

        </div>
    </div>
</x-app-layout>