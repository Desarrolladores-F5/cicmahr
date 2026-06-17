<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                🔎 Búsqueda Avanzada
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Encuentra trabajadores, documentos y horas extras desde un solo lugar.
            </p>

        </div>

    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 hover:-translate-y-1 transition">

        {{-- 🔍 CARD BUSCADOR --}}
        <div class="bg-white border border-gray-100 shadow-md rounded-3xl p-8 mb-8">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                    🔎
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        Buscar trabajador
                    </h3>

                    <p class="text-sm text-gray-500">
                        Busca por nombre, apellido o RUT.
                    </p>
                </div>

            </div>

            <div class="border-t border-gray-100 pt-6">

                @if($q)
                    <p class="text-sm text-gray-500 mb-4">
                        Resultados para
                        <span class="font-semibold text-gray-700">
                            "{{ $q }}"
                        </span>:
                        <span class="font-semibold text-blue-600">
                            {{ $trabajadores->count() }} trabajador(es)
                        </span>
                    </p>
                @endif

                <form method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-4">

                    <input
                        type="text"
                        name="q"
                        id="busquedaInput"
                        value="{{ $q }}"
                        placeholder="Ingrese nombre, apellido o RUT (12345678-9)"
                        class="flex-1 rounded-2xl border-gray-300 px-5 py-4 focus:border-blue-500 focus:ring-blue-500"
                    >

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-7 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition"
                    >
                        🔍 Buscar
                    </button>

                    @if($q)
                        <a
                            href="{{ route('busqueda.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition"
                        >
                            Limpiar
                        </a>
                    @endif

                </form>

            </div>

        </div>

        <div id="resultadosBusqueda">

            @if($q)

                {{-- RESULTADO EN AMARILLO CUANDO BUSCO ALGO --}}
                @php
                    function highlight($text, $q) {
                        return preg_replace("/($q)/i", '<span class="bg-yellow-200 px-1 rounded">$1</span>', $text);
                    }
                @endphp

                @forelse($trabajadores as $t)

                    <div class="bg-white border border-gray-100 shadow-md rounded-3xl p-8 mb-8 hover:shadow-lg transition">

                        {{-- 👤 HEADER TRABAJADOR --}}
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">

                            <div>

                                <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                    👤 {!! highlight($t->nombre . ' ' . $t->apellido, $q) !!}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {!! highlight($t->rut, $q) !!}
                                </p>

                                <div class="mt-4 flex flex-wrap gap-2">

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                        Cargo: {{ $t->cargo ?? '—' }}
                                    </span>

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        Contrato: {{ $t->tipo_contrato ?? '—' }}
                                    </span>

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        Sueldo: ${{ number_format($t->sueldo, 0, ',', '.') }}
                                    </span>

                                </div>

                                <p class="mt-3 text-sm text-gray-500">
                                    🕒 Horario: {{ $t->horario ?? '—' }}
                                </p>

                            </div>

                            <a href="{{ route('trabajadores.edit', $t->id) }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 transition">
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