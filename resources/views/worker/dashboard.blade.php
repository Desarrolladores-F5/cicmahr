<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Bienvenida --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Bienvenido {{ $trabajador->nombre }} {{ $trabajador->apellido }}
        </h1>

        {{-- Información del trabajador --}}
        <div class="bg-white shadow rounded-xl p-6 mb-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <p class="text-sm text-gray-500">Empresa</p>
                    <p class="font-semibold">
                        {{ auth()->user()->empresa->nombre ?? 'Empresa' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Cargo</p>
                    <p class="font-semibold">
                        {{ $trabajador->cargo ?? 'No registrado' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Fecha ingreso</p>
                    <p class="font-semibold">
                        {{ $trabajador->fecha_ingreso
                            ? \Carbon\Carbon::parse($trabajador->fecha_ingreso)->format('d-m-Y')
                            : '-' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Tarjetas rápidas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            {{-- Horas Extras --}}
            <a href="{{ route('worker.horas_extras') }}"
            class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">
                            Mis horas extras
                        </p>

                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($totalMesActual ?? 0, 1) }} hrs
                        </p>

                        <p class="text-sm text-gray-500 mt-2">
                            Ver detalle y monto estimado del mes
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                        ⏱
                    </div>
                </div>
            </a>

            {{-- Tarjeta vacaciones --}}
            <a href="{{ route('worker.vacaciones') }}" 
            class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Vacaciones</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Solicita tus vacaciones y revisa el estado de tus solicitudes.
                        </p>
                    </div>

                    <div class="text-3xl">
                        📅
                    </div>
                </div>
            </a>

            {{-- Tarjeta total documentos --}}
            <div class="bg-white shadow rounded-xl p-6 flex items-center justify-between">

                <div class="flex items-center gap-4">

                    {{-- Icono documentos --}}
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-blue-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6M7 4h10l3 3v13a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Total de documentos</p>

                        <p class="text-3xl font-bold text-gray-800">
                            {{ $totalDocumentos }}
                        </p>
                    </div>

                </div>

                <a href="{{ route('worker.documentos') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Ver
                </a>

            </div>


            {{-- Tarjeta acceso documentos --}}
            <div class="bg-white shadow rounded-xl p-6 flex items-center justify-between">

                <div class="flex items-center gap-4">

                    {{-- Icono carpeta --}}
                    <div class="bg-indigo-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-indigo-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Portal de documentos</p>

                        <p class="text-lg font-semibold text-gray-800">
                            Acceder a mis documentos
                        </p>
                    </div>

                </div>

                <a href="{{ route('worker.documentos') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                    Abrir
                </a>

            </div>

            {{-- Tarjeta documentos nuevos --}}
            <div class="bg-white shadow rounded-xl p-6 flex items-center justify-between">

                <div class="flex items-center gap-4">

                    {{-- Icono bandeja --}}
                    <div class="bg-emerald-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-emerald-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m16 0h-4a2 2 0 01-2 2h-4a2 2 0 01-2-2H4m16 0v6a2 2 0 002 2H6a2 2 0 01-2-2v-6"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Documentos nuevos</p>

                        <p class="text-3xl font-bold text-gray-800">
                            {{ $nuevosDocumentos }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            Últimos 30 días
                        </p>
                    </div>

                </div>

                <a href="{{ route('worker.documentos') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">
                    Ver
                </a>
            </div>
        </div>

        {{-- Últimos documentos --}}
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Tus últimos documentos
            </h2>

            @if($documentos->count())

                <table class="w-full">

                    <thead class="text-left text-gray-500 text-sm">
                        <tr>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach($documentos as $doc)

                            <tr>

                                <td class="py-3">
                                    {{ $doc->tipoDocumento->nombre_documento ?? 'Documento' }}
                                </td>

                                <td>
                                    {{ $doc->fecha_documento
                                        ? \Carbon\Carbon::parse($doc->fecha_documento)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td class="text-right">

                                    <a href="{{ route('worker.documentos.download', $doc) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                        Descargar
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="text-gray-500">
                    Aún no tienes documentos disponibles.
                </p>

            @endif

        </div>

    </div>

</x-app-layout>