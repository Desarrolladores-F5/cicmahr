<x-app-layout>

    <div class="p-8">

        @php

            $totalDestinatarios = $mensaje->destinatarios->count();

            $totalLeidos = $mensaje->destinatarios
                ->where('leido', true)
                ->count();

            $totalPendientes = $totalDestinatarios - $totalLeidos;

            $porcentajeLeido = $totalDestinatarios > 0
                ? round(($totalLeidos / $totalDestinatarios) * 100)
                : 0;

        @endphp

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-8">

            <div>

                <h1 class="text-3xl font-bold text-gray-900">
                    📩 {{ $mensaje->titulo }}
                </h1>

                <p class="mt-2 text-gray-500">
                    Enviado el {{ $mensaje->created_at->format('d/m/Y') }}
                    a las {{ $mensaje->created_at->format('H:i') }}
                </p>

            </div>

            <a href="{{ route('admin.mensajes.index') }}"
               class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition">
                ← Volver
            </a>

        </div>


        {{-- Mensaje --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

            <h2 class="text-xl font-bold text-gray-800 mb-5">
                Mensaje
            </h2>

            <div class="text-gray-700 leading-relaxed whitespace-pre-line">

                {{ $mensaje->mensaje }}

            </div>

        </div>


        {{-- Estadísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            {{-- Destinatarios --}}
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

                <div class="text-3xl mb-3">
                    📨
                </div>

                <p class="text-gray-500 text-sm">
                    Destinatarios
                </p>

                <div class="mt-2 text-3xl font-bold text-gray-800">
                    {{ $totalDestinatarios }}
                </div>

            </div>


            {{-- Leídos --}}
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

                <div class="text-3xl mb-3">
                    ✅
                </div>

                <p class="text-gray-500 text-sm">
                    Leídos
                </p>

                <div class="mt-2 text-3xl font-bold text-green-600">
                    {{ $totalLeidos }}
                </div>

            </div>


            {{-- Pendientes --}}
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

                <div class="text-3xl mb-3">
                    ⏳
                </div>

                <p class="text-gray-500 text-sm">
                    Pendientes
                </p>

                <div class="mt-2 text-3xl font-bold text-yellow-600">
                    {{ $totalPendientes }}
                </div>

            </div>

        </div>


        {{-- Destinatarios --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">

            <div class="px-8 py-6 border-b border-gray-100">

                <h2 class="text-xl font-bold text-gray-800">
                    Destinatarios
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Estado de lectura de cada trabajador.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                Trabajador
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                Fecha de lectura
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($mensaje->destinatarios as $destinatario)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- Nombre --}}
                                <td class="px-6 py-5">

                                    <div class="font-semibold text-gray-800">
                                        {{ $destinatario->user->name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $destinatario->user->email }}
                                    </div>

                                </td>


                                {{-- Estado --}}
                                <td class="px-6 py-5 text-center">

                                    @if($destinatario->leido)

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            ✅ Leído
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                            ⏳ Pendiente
                                        </span>

                                    @endif

                                </td>


                                {{-- Fecha lectura --}}
                                <td class="px-6 py-5 text-center text-gray-600">

                                    @if($destinatario->fecha_lectura)

                                        {{ $destinatario->fecha_lectura->format('d/m/Y H:i') }}

                                    @else

                                        —

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Barra de Progreso --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8 mt-8">

            <div class="flex items-center justify-between mb-4">

                <h2 class="text-xl font-bold text-gray-800">
                    Progreso de lectura
                </h2>

                @if($porcentajeLeido == 100)

                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                        {{ $porcentajeLeido }}% leído
                    </span>

                @else

                    <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                        {{ $porcentajeLeido }}% leído
                    </span>

                @endif

            </div>


            <div class="w-full bg-gray-200 rounded-full h-4">

                <div
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full transition-all duration-500"
                    style="width: {{ $porcentajeLeido }}%"
                ></div>

            </div>

        </div>


    </div>

</x-app-layout>