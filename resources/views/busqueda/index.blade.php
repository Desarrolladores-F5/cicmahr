<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Búsqueda Avanzada
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 hover:-translate-y-1 transition">

        {{-- 📊 CONTADOR DE RESULTADOS --}}
        @if($q)
            <p class="text-sm text-gray-500 mb-4">
                Resultados para "<strong>{{ $q }}</strong>":
                {{ $trabajadores->count() }} trabajador(es)
            </p>
        @endif

        {{-- 🔍 BUSCADOR --}}
        <form method="GET" class="mb-6 flex items-center gap-3">
        
            <input type="text" name="q"
                id="busquedaInput"
                value="{{ $q }}"
                placeholder="Ingrese nombre, apellido o RUT (12345678-9)"
                class="w-full border rounded-lg px-4 py-3">
            
            {{-- 🔍 BOTÓN BUSCAR --}}
            <button class="shadow-sm bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition">
                Buscar
            </button>

            {{-- 🧹 BOTÓN LIMPIAR --}}
            @if($q)
                <a href="{{ route('busqueda.index') }}"
                class="shadow-sm bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition">
                    Limpiar
                </a>
            @endif
        </form>

        <div id="resultadosBusqueda">

            @if($q)

                {{-- RESULTADO EN AMARILLO CUANDO BUSCO ALGO --}}
                @php
                    function highlight($text, $q) {
                        return preg_replace("/($q)/i", '<span class="bg-yellow-200 px-1 rounded">$1</span>', $text);
                    }
                @endphp

                @forelse($trabajadores as $t)

                    <div class="bg-white border rounded-xl p-6 mb-6 shadow-sm hover:shadow-md transition">

                        {{-- 👤 HEADER TRABAJADOR --}}
                        <div class="flex justify-between items-start mb-4">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {!! highlight($t->nombre . ' ' . $t->apellido, $q) !!}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {!! highlight($t->rut, $q) !!}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Cargo: {{ $t->cargo ?? '—' }} |
                                    Contrato: {{ $t->tipo_contrato ?? '—' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Sueldo: ${{ number_format($t->sueldo, 0, ',', '.') }} |
                                    Horario: {{ $t->horario ?? '—' }}
                                </p>

                                @php
                                    $docsTrabajador = $documentos->where('trabajador_id', $t->id);
                                    $horasTrabajador = $horasExtras->where('trabajador_id', $t->id);
                                @endphp

                                <div class="mt-3 text-xs text-gray-500 flex gap-4">
                                    <span>📄 {{ $docsTrabajador->count() }}</span>
                                    <span>⏱ {{ $horasTrabajador->count() }}</span>
                                </div>
                            </div>

                            <a href="{{ route('trabajadores.edit', $t->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                                Ver ficha
                            </a>

                        </div>

                        {{-- 📄 DOCUMENTOS --}}
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                                📄 Documentos
                            </h4>

                            @php
                                $docsTrabajador = $documentos->where('trabajador_id', $t->id);
                            @endphp

                            @forelse($docsTrabajador as $d)
                                <div class="flex justify-between text-sm bg-gray-50 px-3 py-2 rounded mb-2">

                                    <span>
                                        {{ $d->tipoDocumento->nombre_documento ?? 'Documento' }}
                                        ({{ $d->created_at->format('d-m-Y') }})
                                    </span>

                                    <a href="{{ route('documentos.download', [$t->id, $d->id]) }}"
                                    class="text-blue-600 hover:underline">
                                        Descargar
                                    </a>

                                </div>
                            @empty
                                <p class="text-gray-400 text-sm">Sin documentos</p>
                            @endforelse
                        </div>

                        {{-- ⏱ HORAS EXTRAS --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                                ⏱ Horas Extras
                            </h4>

                            @php
                                $horasTrabajador = $horasExtras->where('trabajador_id', $t->id);
                            @endphp

                            @forelse($horasTrabajador as $h)
                                <div class="flex justify-between text-sm bg-gray-50 px-3 py-2 rounded mb-2">

                                    <span>
                                        {{ $h->fecha }} → {{ $h->horas }} hrs
                                        ({{ $h->motivo ?? 'Sin motivo' }})
                                    </span>

                                    <a href="{{ route('horas.extras.index', $t->id) }}"
                                    class="text-blue-600 hover:underline">
                                        Ver
                                    </a>

                                </div>
                            @empty
                                <p class="text-gray-400 text-sm">Sin horas extras</p>
                            @endforelse
                        </div>

                    </div>

                @empty

                    <div class="text-center text-gray-500 py-10">
                        No se encontraron trabajadores
                    </div>

                @endforelse

            @endif
        </div>

    </div>

    <script>
        const input = document.getElementById('busquedaInput');
        const resultados = document.getElementById('resultadosBusqueda');

        let timeout = null;

        input.addEventListener('keyup', function () {

            clearTimeout(timeout);

            const query = this.value;

            // Evita búsquedas vacías
            if (query.length < 2) {
                resultados.innerHTML = '';
                return;
            }

            // Delay tipo Google (evita spam al servidor)
            timeout = setTimeout(() => {

                fetch(`/busqueda?q=${query}`)
                    .then(res => res.text())
                    .then(html => {

                        // Extraemos SOLO los resultados (no toda la página)
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const nuevosResultados = doc.querySelector('#resultadosBusqueda');

                        if (nuevosResultados) {
                            resultados.innerHTML = nuevosResultados.innerHTML;
                        }

                    });

            }, 300); // delay 300ms

        });
    </script>

</x-app-layout>