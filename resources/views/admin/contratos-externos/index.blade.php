<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                📑 Contratos Externos
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Gestiona contratos con empresas proveedoras y personas que prestan servicios externos a la empresa.
            </p>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- ================================================= --}}
                {{-- 🏢 EMPRESAS EXTERNAS --}}
                {{-- ================================================= --}}
                <a href="{{ route('admin.contratos-externos.empresas.index') }}"
                class="group bg-white rounded-3xl border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-8 block">

                    <div class="flex items-center justify-between mb-8">

                        <div class="w-16 h-16 rounded-3xl bg-blue-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                            🏢
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700">
                            Empresas Externas
                        </span>

                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        Empresas Externas
                    </h3>

                    <p class="text-gray-500 leading-relaxed mb-6">
                        Administra contratos con empresas proveedoras, convenios comerciales y servicios externos asociados a la empresa.
                    </p>

                    <div class="space-y-3 text-sm text-gray-600">

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Empresas proveedoras
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Convenios comerciales
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Servicios externos
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-gray-400">○</span>
                            Licitaciones (próximamente)
                        </div>

                    </div>

                    <div class="mt-8">

                        <span
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-2xl font-semibold shadow group-hover:bg-blue-700 transition">

                            Ingresar

                            <span class="group-hover:translate-x-1 transition">
                                →
                            </span>

                        </span>

                    </div>

                </a>

                {{-- ================================================= --}}
                {{-- 👤 HONORARIOS --}}
                {{-- ================================================= --}}
                <a href="{{ route('admin.contratos-externos.honorarios.index') }}"
                class="group bg-white rounded-3xl border border-gray-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-8 block">

                    <div class="flex items-center justify-between mb-8">

                        <div class="w-16 h-16 rounded-3xl bg-emerald-100 flex items-center justify-center text-4xl group-hover:scale-110 transition">
                            👤
                        </div>

                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700">
                            Honorarios
                        </span>

                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        Honorarios
                    </h3>

                    <p class="text-gray-500 leading-relaxed mb-6">
                        Gestiona contratos de personas naturales que prestan servicios profesionales, técnicos o temporales para la empresa.
                    </p>

                    <div class="space-y-3 text-sm text-gray-600">

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Profesionales independientes
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Técnicos especializados
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Reemplazos temporales
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-green-600">✔</span>
                            Servicios puntuales
                        </div>

                    </div>

                    <div class="mt-8">

                        <span
                            class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-3 rounded-2xl font-semibold shadow group-hover:bg-emerald-700 transition">

                            Ingresar

                            <span class="group-hover:translate-x-1 transition">
                                →
                            </span>

                        </span>

                    </div>

                </a>

            </div>  {{-- fin grid empresas / honorarios --}}

            {{-- ================================================= --}}
            {{-- 💡 CENTRO DE INFORMACIÓN --}}
            {{-- ================================================= --}}
            <div class="mt-8 bg-gray-50 border border-gray-100 rounded-3xl p-8">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm">
                        💡
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            ¿Qué puedes administrar aquí?
                        </h3>

                        <p class="text-sm text-gray-500">
                            Organiza contratos externos sin mezclarlos con la dotación interna de trabajadores.
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-2">
                            🏢 Empresas externas
                        </h4>

                        <p class="text-sm text-gray-500 leading-relaxed">
                            Proveedores, convenios comerciales, servicios recurrentes y contratos con empresas.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-2">
                            👤 Honorarios
                        </h4>

                        <p class="text-sm text-gray-500 leading-relaxed">
                            Personas naturales que prestan servicios profesionales, técnicos o trabajos puntuales.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-2">
                            🔔 Alertas futuras
                        </h4>

                        <p class="text-sm text-gray-500 leading-relaxed">
                            Más adelante podrás recibir avisos por contratos próximos a vencer o documentos pendientes.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

