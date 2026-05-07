<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel Admin — CicmaHR
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('pago_ok'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                    Pago realizado correctamente 🎉 Tu cuenta está activa.
                </div>
            @endif

            @if(auth()->user()->empresa && auth()->user()->empresa->enTrial())
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700">
                    Estás en periodo de prueba. Te quedan 
                    <strong>{{ auth()->user()->empresa->diasRestantesTrial() }}</strong> días.
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-10">

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalTrabajadores }}</p>
                </div>

                <div class="bg-green-50 p-6 rounded-xl shadow">
                    <p class="text-sm text-green-600">Vigentes</p>
                    <p class="text-2xl font-bold text-green-700">{{ $vigentes }}</p>
                </div>

                <div class="bg-red-50 p-6 rounded-xl shadow">
                    <p class="text-sm text-red-600">Inactivos</p>
                    <p class="text-2xl font-bold text-red-700">{{ $inactivos }}</p>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl shadow">
                    <p class="text-sm text-blue-600">Plazo Fijo</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $plazoFijo }}</p>
                </div>

                <div class="bg-emerald-50 p-6 rounded-xl shadow">
                    <p class="text-sm text-emerald-600">Indefinido</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $indefinido }}</p>
                </div>

            </div>

            {{-- ===================== --}}
            {{-- MÉTRICAS SUPERIORES --}}
            {{-- ===================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                {{-- PLAN ACTUAL --}}
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 mb-1">Plan Actual</p>
                    <p class="text-2xl font-bold capitalize text-gray-800">
                        {{ $empresa->plan }}
                    </p>
                    <p class="text-sm text-gray-400 mt-1">
                        Incluye hasta {{ $limite }} trabajadores
                    </p>
                </div>

                {{-- TRABAJADORES --}}
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 
                    @if($totalTrabajadores >= $limite) border-red-500 @else border-green-500 @endif">

                    <p class="text-sm text-gray-500 mb-1">Trabajadores</p>

                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalTrabajadores }} / {{ $limite }}
                    </p>

                    {{-- Barra de progreso --}}
                    @php
                        $porcentaje = ($limite > 0) ? ($totalTrabajadores / $limite) * 100 : 0;
                    @endphp

                    <div class="w-full bg-gray-200 rounded-full h-2 mt-4">
                        <div 
                            class="h-2 rounded-full transition-all duration-500
                            @if($porcentaje >= 100) bg-red-500
                            @elseif($porcentaje >= 70) bg-yellow-500
                            @else bg-green-500
                            @endif"
                            style="width: {{ min($porcentaje, 100) }}%">
                        </div>
                    </div>

                    @if($totalTrabajadores >= $limite)
                        <p class="text-red-600 text-sm font-medium mt-2">
                            Límite alcanzado
                        </p>
                    @endif
                </div>

                {{-- ESTADO DEL PLAN --}}
                <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 mb-1">Estado del Plan</p>
                    <p class="text-2xl font-bold text-green-600">
                        Activo
                    </p>
                    <p class="text-sm text-gray-400 mt-1">
                        Sin restricciones activas
                    </p>
                </div>

            </div>


            {{-- ===================== --}}
            {{-- GRÁFICO POR CARGO --}}
            {{-- ===================== --}}
            <div class="mt-12 bg-white rounded-xl shadow-md p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Distribución de Trabajadores por Cargo
                </h3>

                <p class="text-sm text-gray-500 mb-4">
                    Total trabajadores registrados: {{ $totalTrabajadores }}
                </p>

                @if($cargos->count() > 0)
                    <div style="height:300px;">
                        <canvas id="graficoCargos"></canvas>
                    </div>
                @else
                    <p class="text-gray-500">
                        No hay suficientes datos para generar el gráfico.
                    </p>
                @endif

            </div>

            {{-- ===================== --}}
            {{-- MÓDULOS DISPONIBLES --}}
            {{-- ===================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">

                {{-- GESTIÓN --}}
                <a href="{{ route('trabajadores.index') }}"
                   class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                          hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Gestión de Trabajadores
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Ver, editar y eliminar trabajadores registrados.
                    </p>
                </a>

                {{-- CREAR --}}
                <a href="{{ route('trabajadores.create') }}"
                   class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                          hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Crear Trabajador
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Registrar un nuevo trabajador en la empresa.
                    </p>
                </a>

                {{-- ADMINISTRADORES (BASICO Y PYME+) --}}
                <a href="{{ route('admin.administradores.index') }}"
                    class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Administradores
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Gestiona hasta {{ $empresa->limiteAdministradores() }} administradores según tu plan.
                    </p>
                </a>

                {{-- ADMINISTRAR HORAS EXTRAS --}}
                <a href="{{ route('admin.horas_extras.trabajadores') }}"
                    class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                     <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Administración Horas Extras
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Registra y controla las horas extras de los trabajadores.
                    </p>

                </a>

                {{-- MODULO VACACIONES --}}
                <a href="{{ route('admin.vacaciones') }}"
                    class="relative bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    {{-- 🔴 Badge --}}
                    @if(isset($vacacionesPendientes) && $vacacionesPendientes > 0)
                        <span class="absolute top-3 right-3 z-10 bg-red-500 text-white text-xs font-bold min-w-[24px] h-6 px-2 flex items-center justify-center rounded-full">
                            {{ $vacacionesPendientes }}
                        </span>
                    @endif

                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Vacaciones
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Revisa y gestiona las solicitudes de vacaciones de los trabajadores.
                    </p>
                </a>

                {{-- CARGA MASIVA --}}
                <a href="{{ route('admin.documentos.carga') }}"
                    class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Carga Masiva de Documentos
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Sube múltiples PDFs o un ZIP.
                    </p>
                </a>

                {{-- COMITÉ PARITARIO + REGLAMENTO INTERNO --}}
                <a href="{{ route('admin.reglamentos.index') }}"
                    class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Comité Paritario & Reglamento Interno
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Integrantes de Comité Paritario y Reglamento Interno de la empresa.
                    </p>
                </a>

                {{-- HISTORIAL (PRO) --}}
                <a href="{{ route('admin.historial.index') }}"
                class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Historial de Registros
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Historial de todas las acciones realizadas en la plataforma.
                    </p>
                </a>

                {{-- BÚSQUEDA (PRO) --}}
                <a href="{{ route('busqueda.index') }}"
                class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-2 text-gray-800">
                        Búsqueda Avanzada
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Busca trabajadores, documentos y más de forma rápida y sencilla.
                    </p>
                </a>

                {{-- UPGRADE --}}
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-semibold mb-2">
                        Actualice su Plan
                    </h3>
                    <p class="text-sm opacity-90">
                        Haga click acá y actualice su plan por un año más.
                    </p>
                </div>

            </div>

        </div>
    </div>

    @if($cargos->count() > 0)
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const canvas = document.getElementById('graficoCargos');
        if (!canvas) return;

        const labels = @json($cargos->keys());
        const values = @json($cargos->values());

        // Si existiera un gráfico anterior, destruirlo
        if (canvas.chartInstance) {
            canvas.chartInstance.destroy();
        }

        const chart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cantidad',
                    data: values,
                    backgroundColor: [
                        '#2563eb',
                        '#16a34a',
                        '#eab308',
                        '#dc2626',
                        '#7c3aed'
                    ],
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },

                plugins: {
                    legend: { display: false }
                },

                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    }
                }
            }
               
        });

        canvas.chartInstance = chart;
    });
    </script>
    @endif

</x-app-layout>