<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reglamentos de la Empresa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-6">

                @if($reglamentos->isEmpty())
                    <p class="text-gray-500">
                        No hay reglamentos disponibles.
                    </p>
                @else

                    <div class="space-y-4">
                        @foreach($reglamentos as $reglamento)
                            <div class="border rounded-lg p-4 flex justify-between items-center">
                                
                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        {{ $reglamento->nombre }}
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Año: {{ $reglamento->anio }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $reglamento->descripcion }}
                                    </p>
                                </div>

                                <a href="{{ route('worker.reglamentos.download', $reglamento) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    Descargar
                                </a>

                            </div>
                        @endforeach
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>