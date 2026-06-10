<x-app-layout>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-900">
                Centro de Actividad 🔔
            </h1>

            <p class="mt-2 text-gray-500">
                Revisa los últimos movimientos importantes dentro de CicmaHR.
            </p>

        </div>


        {{-- Card principal --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">

            <div class="px-8 py-6 border-b border-gray-100">

                <h2 class="text-xl font-bold text-gray-800">
                    Actividad reciente
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Por ahora mostramos actividad relacionada con mensajes leídos.
                </p>

            </div>


            @if($actividades->count())

                <div class="divide-y divide-gray-100">

                    @php
                        $grupoAnterior = null;
                    @endphp

                    @foreach($actividades as $actividad)

                        @php

                            $fecha = \Carbon\Carbon::parse($actividad['fecha']);

                            if ($fecha->isToday()) {
                                $grupoActual = '📅 Hoy';
                            } elseif ($fecha->isYesterday()) {
                                $grupoActual = '📅 Ayer';
                            } elseif ($fecha->greaterThan(now()->subWeek())) {
                                $grupoActual = '📅 Esta semana';
                            } else {
                                $grupoActual = '📅 Anteriores';
                            }

                        @endphp

                        @if($grupoActual !== $grupoAnterior)

                            <div class="px-8 py-5 bg-gray-50 border-y border-gray-100">

                                <h3 class="text-lg font-bold text-gray-800">

                                    {{ $grupoActual }}

                                </h3>

                            </div>

                            @php
                                $grupoAnterior = $grupoActual;
                            @endphp

                        @endif

                        <div class="px-8 py-6 hover:bg-gray-50 transition">

                            <div class="flex items-start gap-4">

                                <div class="w-12 h-12 rounded-2xl {{ $actividad['icon_class'] }} flex items-center justify-center text-2xl">

                                    {{ $actividad['icono'] }}

                                </div>

                                <div class="flex-1">

                                    <p class="font-semibold text-gray-800">

                                        {{ $actividad['titulo'] }}

                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">

                                        {{ $actividad['detalle'] }}

                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">

                                        {{ \Carbon\Carbon::parse($actividad['fecha'])->locale('es')->diffForHumans() }}

                                    </p>

                                </div>

                               <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $actividad['badge_class'] }}">
                                    
                                    {{ $actividad['badge'] }}

                                </span>

                            </div>

                        </div>

                    @endforeach

                    <div class="px-8 py-6 border-t border-gray-100">

                        {{ $actividades->links() }}

                    </div>

                </div>

            @else

                <div class="p-12 text-center">

                    <div class="text-5xl mb-4">
                        🔕
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Aún no hay actividad reciente
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Cuando los trabajadores lean mensajes, aparecerán aquí.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>