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

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

                {{-- PROFESIONALES --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                            👤
                        </div>

                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                            Profesionales
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-emerald-700">
                        0
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Profesionales registrados
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
                        0
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Contratos activos
                    </p>

                </div>

                {{-- PAGOS --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-lime-100 flex items-center justify-center text-2xl">
                            💰
                        </div>

                        <span class="px-3 py-1 rounded-full bg-lime-50 text-lime-700 text-xs font-semibold">
                            Pagos
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-lime-700">
                        0
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Pagos pendientes
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
                        0
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
                            Profesionales Registrados
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Busca, administra y registra profesionales independientes y prestadores de servicios.
                        </p>

                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <div class="relative">

                            <input
                                type="text"
                                placeholder="Buscar profesional..."
                                class="w-72 rounded-2xl border-gray-300 pl-11 pr-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                            <span class="absolute left-4 top-3.5 text-gray-400">
                                🔍
                            </span>

                        </div>

                        <button
                            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition">

                            ➕

                            Registrar Profesional

                        </button>

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 👤 EMPTY STATE --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-16 text-center">

                <div class="text-7xl mb-6">
                    👤
                </div>

                <h3 class="text-3xl font-bold text-gray-900">
                    Aún no existen profesionales registrados
                </h3>

                <p class="mt-4 max-w-2xl mx-auto text-gray-500 leading-relaxed">
                    Registra consultores, técnicos, asesores o prestadores de servicios
                    para comenzar a administrar sus contratos desde CicmaHR.
                </p>

                <div class="mt-10">
                    <button
                        class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg transition">

                        ➕

                        Registrar Primer Profesional

                    </button>
                </div>

            </div>


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
                    Estos profesionales no forman parte de la dotación permanente de la empresa.
                </p>

            </div>

        </div>
    </div>

</x-app-layout>