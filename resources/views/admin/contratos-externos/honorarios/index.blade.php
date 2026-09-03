<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                👤 Honorarios
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Administra profesionales independientes, técnicos y prestadores de servicios externos que colaboran con la empresa.
            </p>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📊 MÉTRICAS --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                {{-- PRESTADORES --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                            👤
                        </div>

                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                            Prestadores
                        </span>

                    </div>

                    <p class="mt-7 text-4xl font-bold text-emerald-700">
                        {{ $totalPrestadores }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Prestadores registrados
                    </p>

                </div>

                {{-- CONTRATOS --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                            Contratos
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-green-700">
                        {{ $contratosActivos }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Contratos activos
                    </p>

                </div>

                {{-- RENOVACIONES --}}
                <div class="bg-white rounded-3xl shadow-md border border-amber-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                            ⚠️
                        </div>

                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-semibold">
                            Renovar
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-amber-700">
                        {{ $contratosPorVencer }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Próximos a vencer
                    </p>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 🚀 ACCIONES PRINCIPALES --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl border border-gray-100 shadow-md p-6 mb-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    <div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Prestadores Registrados
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Busca, administra y registra profesionales independientes y prestadores de servicios.
                        </p>

                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <div class="relative">

                            <input
                                type="text"
                                placeholder="Buscar prestadores..."
                                class="w-72 rounded-2xl border-gray-300 pl-11 pr-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                            <span class="absolute left-4 top-3.5 text-gray-400">
                                🔍
                            </span>

                        </div>

                        <a
                            href="{{ route('admin.contratos-externos.honorarios.create') }}"
                            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition"
                        >

                            ➕

                            Registrar Prestador

                        </a>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- 👥 LISTADO DE PRESTADORES --}}
            {{-- ========================================================= --}}

            @if($honorarios->isEmpty())

                {{-- ===================================================== --}}
                {{-- 📭 EMPTY STATE --}}
                {{-- ===================================================== --}}

                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-16 text-center mb-10">

                    <div class="w-24 h-24 mx-auto rounded-3xl bg-emerald-50 flex items-center justify-center text-5xl">

                        👤

                    </div>

                    <h2 class="mt-7 text-3xl font-bold text-gray-900">

                        Aún no existen prestadores registrados

                    </h2>

                    <p class="mt-4 max-w-2xl mx-auto text-gray-500 leading-relaxed">

                        Registra personas que presten servicios profesionales, técnicos
                        o temporales para mantener sus antecedentes y contratos organizados.

                    </p>

                    <div class="mt-10">

                        <a
                            href="{{ route('admin.contratos-externos.honorarios.create') }}"
                            class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg transition"
                        >

                            ➕

                            Registrar Primer Prestador

                        </a>

                    </div>

                </div>

            @else

                {{-- ===================================================== --}}
                {{-- 🐙 KRAKEN: PRESTADORES REGISTRADOS --}}
                {{-- ===================================================== --}}

                <div class="grid gap-6 mb-10">

                    @foreach($honorarios as $honorario)

                        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-7">

                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                                {{-- ========================================= --}}
                                {{-- 👤 INFORMACIÓN DEL PRESTADOR --}}
                                {{-- ========================================= --}}

                                <div class="flex items-start gap-5">

                                    <div class="w-16 h-16 shrink-0 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">

                                        👤

                                    </div>

                                    <div>

                                        <div class="flex flex-wrap items-center gap-3">

                                            <h3 class="text-xl font-bold text-gray-900">

                                                {{ $honorario->nombre }} {{ $honorario->apellido }}

                                            </h3>

                                            @if($honorario->estado === 'activo')

                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">

                                                    🟢 Activo

                                                </span>

                                            @else

                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">

                                                    ⚪ Inactivo

                                                </span>

                                            @endif

                                        </div>

                                        <p class="mt-2 text-sm text-gray-500">

                                            RUT: {{ $honorario->rut }}

                                        </p>

                                        @if($honorario->profesion_oficio)

                                            <p class="mt-1 text-gray-600">

                                                {{ $honorario->profesion_oficio }}

                                            </p>

                                        @endif

                                    </div>

                                </div>

                                {{-- ========================================= --}}
                                {{-- ⚙️ ACCIONES --}}
                                {{-- ========================================= --}}

                                <div class="flex flex-wrap items-center gap-3">

                                    <a
                                        href="{{ route('admin.contratos-externos.honorarios.show', $honorario) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-semibold px-5 py-3 transition"
                                    >

                                        👁️ Ver Expediente

                                    </a>

                                    <a
                                        href="#"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-3 transition"
                                    >

                                        ✏️ Editar

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- 💡 BLOQUE INFORMATIVO --}}
            {{-- ================================================= --}}

            <div class="mt-8 bg-emerald-50 border border-emerald-100 rounded-3xl p-8">

                <div class="flex items-center justify-between gap-4 mb-6">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                            💡
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                ¿Quiénes pueden registrarse aquí?
                            </h3>

                            <p class="text-sm text-gray-500">
                                Personas que prestan servicios externos sin formar parte de la dotación permanente.
                            </p>
                        </div>

                    </div>

                    <span class="hidden sm:inline-flex px-3 py-1 rounded-full bg-white text-emerald-700 text-xs font-semibold shadow-sm">
                        Ayuda
                    </span>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 text-sm text-gray-700">

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Abogados externos
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Contadores
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Técnicos especializados
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Relatores de capacitación
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Jardineros
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Personal de aseo
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Reemplazos temporales
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-emerald-100 shadow-sm">
                        ✔ Consultores
                    </div>

                </div>

                <p class="mt-6 text-sm text-emerald-800">
                    Estos prestadores no forman parte de la dotación permanente de la empresa.
                </p>

            </div>

        </div>
    </div>

</x-app-layout>