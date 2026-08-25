<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                🏢 Empresas Externas
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Administra proveedores, convenios comerciales y empresas que mantienen contratos vigentes con la organización.
            </p>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📊 MÉTRICAS --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

                {{-- EMPRESAS --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                            🏢
                        </div>

                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                            Empresas
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-blue-700">
                        {{ $empresasExternas->count() }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Empresas registradas
                    </p>

                </div>

                {{-- CONVENIOS --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                            🤝
                        </div>

                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                            Convenios
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-green-700">
                        0
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Convenios activos
                    </p>

                </div>

                {{-- CONTRATOS --}}
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                            Contratos
                        </span>

                    </div>

                    <h3 class="text-3xl font-bold text-indigo-700">
                        0
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Contratos vigentes
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
                            Empresas Externas Registradas
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Busca, administra y registra empresas proveedoras de forma rápida.
                        </p>

                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <div class="relative">

                            <input
                                type="text"
                                placeholder="Buscar empresa..."
                                class="w-72 rounded-2xl border-gray-300 pl-11 pr-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                            <span class="absolute left-4 top-3.5 text-gray-400">
                                🔍
                            </span>

                        </div>

                        <a
                            href="{{ route('admin.contratos-externos.empresas.create') }}"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-2xl shadow-md transition">

                            ➕

                            Registrar Empresa Externa

                        </a>

                    </div>

                </div>

            </div>


            @if($empresasExternas->isEmpty())

                {{-- ================================================= --}}
                {{-- 🏢 EMPTY STATE --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-16 text-center">

                    <div class="text-7xl mb-6">
                    🏢
                    </div>

                    <h3 class="text-3xl font-bold text-gray-900">
                        Aún no existen empresas externas
                    </h3>

                    <p class="mt-4 max-w-2xl mx-auto text-gray-500 leading-relaxed">

                        Registra empresas proveedoras, convenios comerciales y servicios
                        externos para comenzar a administrar contratos desde CicmaHR.

                    </p>

                    <div class="mt-10">

                        <a
                            href="{{ route('admin.contratos-externos.empresas.create') }}"
                            class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg transition">

                            ➕

                            Registrar Primera Empresa

                        </a>

                    </div>

                </div>

            @else

                <div class="grid gap-6">

                    @foreach($empresasExternas as $empresa)

                        <div class="bg-white rounded-3xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-8">

                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                                {{-- ================================================ --}}
                                {{-- 🏢 INFORMACIÓN PRINCIPAL --}}
                                {{-- ================================================ --}}

                                <div class="flex-1">

                                    <div class="flex items-center gap-4 mb-4">

                                        <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

                                            🏢

                                        </div>

                                        <div>

                                            <h2 class="text-2xl font-bold text-gray-900">

                                                {{ $empresa->nombre_fantasia ?: $empresa->razon_social }}

                                            </h2>

                                            @if($empresa->nombre_fantasia)

                                                <p class="text-gray-500 text-sm mt-1">

                                                    {{ $empresa->razon_social }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

                                        <div>

                                            <p class="text-xs uppercase tracking-wide text-gray-400">
                                                RUT
                                            </p>

                                            <p class="font-semibold text-gray-800">
                                                {{ $empresa->rut_empresa }}
                                            </p>

                                        </div>

                                        <div>

                                            <p class="text-xs uppercase tracking-wide text-gray-400">
                                                Actividad
                                            </p>

                                            <p class="font-semibold text-gray-800">
                                                {{ $empresa->actividad }}
                                            </p>

                                        </div>

                                        <div>

                                            <p class="text-xs uppercase tracking-wide text-gray-400">
                                                Representante Legal
                                            </p>

                                            <p class="font-semibold text-gray-800">
                                                {{ $empresa->nombre_representante }}
                                            </p>

                                        </div>

                                        <div>

                                            <p class="text-xs uppercase tracking-wide text-gray-400">
                                                Estado
                                            </p>

                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                                                🟢 {{ ucfirst($empresa->estado) }}

                                            </span>

                                        </div>

                                    </div>

                                </div>

                                {{-- ================================================ --}}
                                {{-- 🚀 ACCIONES --}}
                                {{-- ================================================ --}}

                                <div class="flex flex-col gap-3 lg:w-52">

                                    <a
                                        href="{{ route('admin.contratos-externos.empresas.show', $empresa) }}"
                                        class="w-full inline-flex items-center justify-center rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 transition">

                                        👁 Ver Expediente

                                    </a>

                                    <a
                                        href="{{ route('admin.contratos-externos.empresas.edit', $empresa) }}"
                                        class="w-full rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 transition">

                                        ✏️ Editar

                                    </a>

                                    <a
                                        href="{{ route('admin.contratos-externos.empresas.documentos.index', $empresa) }}"
                                        class="w-full rounded-2xl bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold py-3 transition">

                                        📄 Documentos

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif


        </div>
    
    </div>

</x-app-layout>