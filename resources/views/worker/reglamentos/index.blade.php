<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reglamentos de la Empresa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-6">

                @if($pendientes > 0)
                    <div class="mb-4 flex items-center gap-2 bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-lg">
                        <span class="text-lg">🔔</span>
                        <span>Tienes <strong>{{ $pendientes }}</strong> reglamento(s) pendiente(s) de lectura.</span>
                    </div>
                @endif

                @if($reglamentos->isEmpty())
                    <p class="text-gray-500">
                        No hay reglamentos disponibles.
                    </p>
                @else

                    <div class="space-y-4">
                        @foreach($reglamentos as $reglamento)
                            <div class="border rounded-lg p-4 flex justify-between items-start gap-6">
                                <!-- tu contenido -->
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-4">
                        @foreach($reglamentos as $reglamento)
                            <div class="border rounded-lg p-4 flex justify-between items-start gap-6">

                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">
                                        {{ $reglamento->nombre }}
                                    </h3>

                                    @if(isset($entregas[$reglamento->id]) && $entregas[$reglamento->id]->leido)
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium inline-block mt-2">
                                            ✔ Lectura aceptada
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium inline-block mt-2">
                                            ⏳ Pendiente de lectura
                                        </span>
                                    @endif

                                    <p class="text-sm text-gray-500 mt-2">
                                        Año: {{ $reglamento->anio }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $reglamento->descripcion }}
                                    </p>
                                </div>

                                <div class="w-full max-w-xs space-y-3">
                                    @if(isset($entregas[$reglamento->id]) && $entregas[$reglamento->id]->leido)
                                        <span class="text-green-600 text-sm font-medium block">
                                            ✔ Reglamento aceptado
                                        </span>

                                        <p class="text-xs text-gray-500">
                                            Puedes descargar el reglamento cuando quieras.
                                        </p>
                                    @else
                                        <form action="{{ route('worker.reglamentos.aceptar', $reglamento) }}" method="POST" class="space-y-2">
                                            @csrf

                                            <label class="flex items-start space-x-2 text-sm text-gray-700">
                                                <input type="checkbox"
                                                    name="acepta_lectura"
                                                    id="check_{{ $reglamento->id }}"
                                                    class="rounded border-gray-300 mt-1">
                                                <span>Declaro haber leído el reglamento</span>
                                            </label>

                                            @error('acepta_lectura')
                                                <p class="text-red-500 text-xs mt-1">
                                                    Debes aceptar que leíste el reglamento.
                                                </p>
                                            @enderror

                                            <button type="submit"
                                                id="accept_btn_{{ $reglamento->id }}"
                                                disabled
                                                class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                                Aceptar reglamento
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('worker.reglamentos.download', $reglamento) }}"
                                        id="btn_{{ $reglamento->id }}"
                                        class="block text-center px-4 py-2 rounded-lg text-sm
                                        {{ (isset($entregas[$reglamento->id]) && $entregas[$reglamento->id]->leido)
                                            ? 'bg-blue-600 hover:bg-blue-700 text-white'
                                            : 'bg-gray-400 text-white cursor-not-allowed pointer-events-none' }}">
                                        Descargar
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                @endif

            </div>

        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            
            @foreach($reglamentos as $reglamento)

                const checkbox{{ $reglamento->id }} = document.getElementById('check_{{ $reglamento->id }}');
                const acceptBtn{{ $reglamento->id }} = document.getElementById('accept_btn_{{ $reglamento->id }}');

                if (checkbox{{ $reglamento->id }} && acceptBtn{{ $reglamento->id }}) {
                    checkbox{{ $reglamento->id }}.addEventListener('change', function () {

                        if (this.checked) {
                            acceptBtn{{ $reglamento->id }}.disabled = false;
                            acceptBtn{{ $reglamento->id }}.classList.remove('bg-gray-400', 'cursor-not-allowed');
                            acceptBtn{{ $reglamento->id }}.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        } else {
                            acceptBtn{{ $reglamento->id }}.disabled = true;
                            acceptBtn{{ $reglamento->id }}.classList.add('bg-gray-400', 'cursor-not-allowed');
                            acceptBtn{{ $reglamento->id }}.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        }

                    });

                }

            @endforeach

        });

    </script>

</x-app-layout>