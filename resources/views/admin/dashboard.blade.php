<x-app-layout>
   <x-slot name="header">
        <div class="flex items-center justify-between gap-6">

            <div>

                <h2 class="text-3xl font-bold text-gray-900">
                    Bienvenido, {{ auth()->user()->empresa->nombre ?? 'Empresa' }} 👋
                </h2>

                <p class="text-gray-500 mt-2">
                    Gestiona trabajadores, vacaciones y operaciones de tu empresa.
                </p>

            </div>

            @if(auth()->user()->previous_login_at)
                <div class="hidden md:block bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3 text-right shadow-sm">

                    <p class="text-xs text-gray-400 uppercase tracking-wide">
                        Último acceso
                    </p>

                    <p class="text-sm font-semibold text-gray-700 mt-1">
                        📅 {{ auth()->user()->previous_login_at->format('d/m/Y H:i') }}
                    </p>

                </div>
            @endif

        </div>
        
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

            {{-- BANNER DE AVISO DE FIN DE SUSCRIPCIÓN --}}
            @php
                $empresa = auth()->user()->empresa;

                $diasRestantesSuscripcion = null;

                if (
                    $empresa &&
                    $empresa->suscripcion_activa &&
                    $empresa->suscripcion_hasta
                ) {
                    $diasRestantesSuscripcion = (int) ceil(now()->diffInRealDays(
                        $empresa->suscripcion_hasta,
                        false
                    ));
                }
            @endphp

            @if(
                $diasRestantesSuscripcion !== null &&
                $diasRestantesSuscripcion >= 0 &&
                $diasRestantesSuscripcion <= 5
            )

                <div class="mb-6 bg-orange-50 border border-orange-200 rounded-2xl p-5">

                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div>

                            <h3 class="font-semibold text-orange-800">
                                ⚠️ Tu suscripción vence pronto
                            </h3>

                            <p class="text-orange-700 mt-1">
                                Tu acceso a CicmaHR vence en
                                <strong>{{ $diasRestantesSuscripcion }}</strong>
                                día(s).

                                Renueva ahora para evitar interrupciones en el servicio.
                            </p>

                        </div>

                        <a href="{{ route('planes.index') }}"
                        class="px-5 py-3 bg-orange-500 hover:bg-orange-600
                                text-white rounded-xl font-semibold transition">

                            Renovar ahora

                        </a>

                    </div>

                </div>

            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-6 mb-10">

                {{-- TOTAL --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                            👥
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-600">
                            Total
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ $totalTrabajadores }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Trabajadores registrados
                    </p>

                </div>

                {{-- VIGENTES --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                            🟢
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-50 text-green-600">
                            Activos
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-green-700">
                        {{ $vigentes }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Trabajadores vigentes
                    </p>

                </div>

                {{-- INACTIVOS --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                            🔴
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-50 text-red-600">
                            Inactivos
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-red-700">
                        {{ $inactivos }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Trabajadores no vigentes
                    </p>

                </div>

                {{-- PLAZO FIJO --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-600">
                            Contrato
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-blue-700">
                        {{ $plazoFijo }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Contratos plazo fijo
                    </p>

                </div>

                {{-- INDEFINIDOS --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                            🏢
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-600">
                            Permanente
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-emerald-700">
                        {{ $indefinido }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Contratos indefinidos
                    </p>

                </div>

                {{-- CONTRATOS POR VENCER --}}
                <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-amber-100 hover:-translate-y-1">

                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                            ⚠️
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-50 text-amber-700">
                            Alerta
                        </span>
                    </div>

                    <h3 class="text-3xl font-bold text-amber-700">
                        {{ $totalContratosPorVencer }}
                    </h3>

                    <p class="text-gray-500 mt-2 text-sm">
                        Contratos por vencer
                    </p>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 🔔 CONTRATOS PRÓXIMOS A VENCER --}}
            {{-- ================================================= --}}
            <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-8 mt-8">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                        ⚠️
                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Contratos próximos a vencer
                        </h2>

                        <p class="text-sm text-gray-500">
                            Trabajadores cuyo contrato finaliza en los próximos 30 días.
                        </p>

                    </div>

                </div>

                <div class="border-t border-gray-100 pt-6">

                    @if($contratosPorVencer->isEmpty())

                        <div class="text-center py-8 text-gray-500">
                            No existen contratos próximos a vencer.
                        </div>

                    @else

                        <div class="overflow-x-auto">

                            <table class="min-w-full">

                                <thead class="bg-gray-50 text-xs uppercase text-gray-500">

                                    <tr>
                                        <th class="px-6 py-3 text-left">Trabajador</th>
                                        <th class="px-6 py-3 text-left">Fecha término</th>
                                        <th class="px-6 py-3 text-left">Días restantes</th>
                                        <th class="px-6 py-3 text-left">Acción</th>
                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-gray-100">

                                    @foreach($contratosPorVencer as $trabajador)

                                        <tr class="hover:bg-amber-50 transition">

                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $trabajador->nombre }}
                                                {{ $trabajador->apellido }}
                                            </td>

                                            <td class="px-6 py-4 text-gray-600">
                                                {{ \Carbon\Carbon::parse($trabajador->fecha_salida)->format('d-m-Y') }}
                                            </td>

                                            <td class="px-6 py-4">

                                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm font-semibold">

                                                    {{ $trabajador->dias_restantes }}
                                                    días

                                                </span>

                                            </td>

                                            <td class="px-6 py-4">

                                                <a
                                                    href="{{ route('trabajadores.edit', $trabajador->id) }}"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow"
                                                >
                                                    Ver ficha
                                                </a>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 🔔 CENTRO DE ALERTAS INTELIGENTES --}}
            {{-- ================================================= --}}
            <div class="bg-white rounded-3xl shadow-md border border-blue-100 p-8 mt-8">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                        🔔
                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Centro de Alertas Inteligentes
                        </h2>

                        <p class="text-sm text-gray-500">
                            Elementos que requieren atención o revisión.
                        </p>

                    </div>

                </div>

                <div class="border-t border-gray-100 pt-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                        {{-- VACACIONES PENDIENTES --}}
                        <a href="{{ route('admin.vacaciones') }}"
                        class="bg-amber-50 border border-amber-100 rounded-3xl p-6 hover:shadow-md hover:-translate-y-1 transition block">

                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                                    🏖️
                                </div>

                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-700">
                                    Vacaciones
                                </span>
                            </div>

                            <h3 class="text-3xl font-bold text-amber-700">
                                {{ $vacacionesPendientes }}
                            </h3>

                            <p class="text-sm text-amber-800 mt-2">
                                Solicitudes pendientes
                            </p>

                        </a>


                        {{-- HORAS EXTRAS PENDIENTES --}}
                        <a href="{{ route('admin.horas_extras.trabajadores') }}"
                        class="bg-blue-50 border border-blue-100 rounded-3xl p-6 hover:shadow-md hover:-translate-y-1 transition block">

                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                                    ⏱️
                                </div>

                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                    Horas Extras
                                </span>
                            </div>

                            <h3 class="text-3xl font-bold text-blue-700">
                                {{ $horasExtrasPendientes }}
                            </h3>

                            <p class="text-sm text-blue-800 mt-2">
                                Pendientes de aprobación
                            </p>

                        </a>


                        {{-- MENSAJES SIN LEER --}}
                        <a href="{{ route('admin.mensajes.index') }}"
                        class="bg-indigo-50 border border-indigo-100 rounded-3xl p-6 hover:shadow-md hover:-translate-y-1 transition block">

                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                                    ✉️
                                </div>

                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700">
                                    Mensajes
                                </span>
                            </div>

                            <h3 class="text-3xl font-bold text-indigo-700">
                                {{ $mensajesSinLeer }}
                            </h3>

                            <p class="text-sm text-indigo-800 mt-2">
                                Mensajes sin leer
                            </p>

                        </a>


                        {{-- ANIVERSARIOS LABORALES --}}
                        <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-6">

                            <div class="flex items-center justify-between mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                                    🏆
                                </div>

                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                    Aniversarios laborales
                                </span>
                            </div>

                            <h3 class="text-3xl font-bold text-emerald-700">
                                {{ $aniversariosLaborales }}
                            </h3>

                            <p class="text-sm text-emerald-800 mt-2">
                                Este mes
                            </p>

                        </div>
                    
                    </div>  {{-- fin grid --}}

                </div> {{-- fin border-t --}}

            </div> {{-- FIN CENTRO DE ALERTAS INTELIGENTES --}  


            {{-- ===================== --}}
            {{-- GRÁFICO POR CARGO --}}
            {{-- ===================== --}}
            <div class="mt-12 bg-white rounded-3xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                    Distribución de Trabajadores por Cargo
                </h3>

                <p class="text-sm text-gray-400 mb-8">
                    Total trabajadores registrados: {{ $totalTrabajadores }}
                </p>

                @if($cargos->count() > 0)
                    <div style="height:380px;">
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
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            👥

                        </div>

                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                            Gestión
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Gestión de Trabajadores
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Ver, editar y administrar trabajadores registrados en la empresa.
                    </p>

                </a>

                {{-- CREAR --}}
                <a href="{{ route('trabajadores.create') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            ➕

                        </div>

                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                            Crear
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Crear Trabajador
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Registrar un nuevo trabajador dentro de la empresa.
                    </p>

                </a>

                {{-- ADMINISTRADORES --}}
                <a href="{{ route('admin.administradores.index') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            🛡️

                        </div>

                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                            Control
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Administradores
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Gestiona hasta {{ $empresa->limiteAdministradores() }} administradores según tu plan.
                    </p>

                </a>

                {{-- HORAS EXTRAS --}}
                <a href="{{ route('admin.horas_extras.trabajadores') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            ⏱️

                        </div>

                        <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                            Gestión
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Horas Extras
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Registra y controla las horas extras de los trabajadores.
                    </p>

                </a>

                {{-- MODULO VACACIONES --}}
                <a href="{{ route('admin.vacaciones') }}"
                    class="group relative bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    {{-- 🔴 Badge --}}
                    @if(isset($vacacionesPendientes) && $vacacionesPendientes > 0)

                        <span class="absolute top-5 right-5 z-10 bg-red-500 text-white text-xs font-bold
                                    min-w-[28px] h-7 px-2 flex items-center justify-center rounded-full shadow-lg">

                            {{ $vacacionesPendientes }}

                        </span>

                    @endif

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            🌴

                        </div>

                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                            Gestión
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Vacaciones
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Revisa y administra solicitudes de vacaciones de los trabajadores.
                    </p>

                </a>

                {{-- CARGA MASIVA --}}
                <a href="{{ route('admin.documentos.carga') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            📂

                        </div>

                        <span class="text-xs font-semibold text-sky-600 bg-sky-50 px-3 py-1 rounded-full">
                            Documentos
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Carga Masiva
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Sube múltiples documentos PDF o archivos ZIP de forma rápida.
                    </p>

                </a>

                {{-- COMITÉ + REGLAMENTO --}}
                <a href="{{ route('admin.reglamentos.index') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            📘

                        </div>

                        <span class="text-xs font-semibold text-violet-600 bg-violet-50 px-3 py-1 rounded-full">
                            Empresa
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Comité & Reglamento
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Gestiona reglamentos internos y comité paritario de la empresa.
                    </p>

                </a>

                {{-- HISTORIAL --}}
                <a href="{{ route('admin.historial.index') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            🕘

                        </div>

                        <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                            Auditoría
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Historial de Registros
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Revisa todas las acciones y movimientos realizados en la plataforma.
                    </p>

                </a>

                {{-- BÚSQUEDA AVANZADA --}}
                <a href="{{ route('busqueda.index') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            🔎

                        </div>

                        <span class="text-xs font-semibold text-cyan-600 bg-cyan-50 px-3 py-1 rounded-full">
                            Inteligente
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Búsqueda Avanzada
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Encuentra trabajadores, documentos y registros de forma rápida y eficiente.
                    </p>

                </a>

                {{-- MENSAJERÍA INTERNA --}}
                <a href="{{ route('admin.mensajes.index') }}"
                class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 p-7 border border-gray-100 hover:-translate-y-1 block">

                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                            ✉️
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-600">
                            Comunicación
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        Mensajería Interna
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Envía comunicados y mensajes importantes a los trabajadores.
                    </p>

                </a>

                {{-- CENTRO DE ACTIVIDAD --}}
                <a href="{{ route('admin.actividad.index') }}"
                    class="group bg-white rounded-3xl p-7 border border-gray-100 shadow-md
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

                    <div class="flex items-center justify-between mb-6">

                        <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center
                                    text-2xl group-hover:scale-110 transition">

                            🔔

                        </div>

                        <span class="text-xs font-semibold text-sky-600 bg-sky-50 px-3 py-1 rounded-full">
                            Actividad
                        </span>

                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        Centro de Actividad
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed">
                        Revisa las últimas acciones importantes realizadas dentro de la empresa.
                    </p>

                </a>


                {{-- UPGRADE PLAN --}}
                <a href="{{ route('planes.index') }}"
                    class="group relative overflow-hidden bg-gradient-to-br from-blue-500 via-indigo-500 to-violet-600
                        text-white rounded-3xl p-7 shadow-xl hover:shadow-2xl
                        hover:-translate-y-2 transition-all duration-300">

                    {{-- Glow --}}
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10">

                        <div class="flex items-center justify-between mb-6">

                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center
                                        text-2xl group-hover:scale-110 transition">

                                🚀

                            </div>

                            <span class="text-xs font-semibold bg-white/10 px-3 py-1 rounded-full">
                                Premium
                            </span>

                        </div>

                        <h3 class="text-2xl font-bold mb-3">
                            Actualice su Plan
                        </h3>

                        <p class="text-sm text-white/80 leading-relaxed">
                            Desbloquee más funcionalidades y amplíe los límites de su empresa.
                        </p>

                        <div class="mt-6 flex items-center gap-2 text-sm font-semibold">

                            <span>Actualizar ahora</span>

                            <span class="group-hover:translate-x-1 transition-transform">
                                →
                            </span>

                        </div>

                    </div>

                </a>

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

        const gradient = canvas.getContext('2d').createLinearGradient(0, 0, 0, 400);

            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.9)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.15)');

            const chart = new Chart(canvas, {

                type: 'bar',

                data: {
                    labels: labels,

                    datasets: [{
                        label: 'Trabajadores',

                        data: values,

                        backgroundColor: gradient,

                        hoverBackgroundColor: '#2563eb',

                        borderRadius: 14,

                        borderSkipped: false,

                        maxBarThickness: 70
                    }]
                },

                options: {

                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },

                    animation: {
                        duration: 1400,
                        easing: 'easeOutExpo'
                    },

                    plugins: {

                        legend: {
                            display: false
                        },

                        tooltip: {

                            backgroundColor: '#081028',

                            titleColor: '#ffffff',

                            bodyColor: '#d1d5db',

                            borderColor: 'rgba(255,255,255,0.08)',

                            borderWidth: 1,

                            padding: 14,

                            displayColors: false,

                            cornerRadius: 14,

                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },

                            bodyFont: {
                                size: 13
                            }
                        }
                    },

                    scales: {

                        x: {

                            grid: {
                                display: false
                            },

                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0,

                                color: '#9ca3af',

                                font: {
                                    size: 12
                                }
                            },

                            grid: {
                                color: 'rgba(0,0,0,0.04)',
                                drawBorder: false
                            },

                            border: {
                                display: false
                            }
                        }
                    }
                }
            });

        canvas.chartInstance = chart;
    });
    </script>
    @endif

</x-app-layout>