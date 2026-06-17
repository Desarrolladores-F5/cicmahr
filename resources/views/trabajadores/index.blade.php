<x-app-layout>
    {{-- ========================= --}}
    {{-- HEADER (Título + Botón) --}}
    {{-- ========================= --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    👥 Trabajadores
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra y controla los trabajadores de tu empresa.
                </p>
            </div>

            <div class="flex items-center gap-3">

                {{-- Botón para ir al dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold transition">
                    ← Dashboard
                </a>

                {{-- Botón para descargar nómina en Excel --}}
                <a href="{{ route('trabajadores.export.excel') }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 transition text-white px-5 py-3 rounded-xl shadow">
                    Exportar Excel
                </a>

                {{-- Botón para crear trabajador --}}
                <a href="{{ route('trabajadores.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-3 rounded-xl shadow">
                    + Nuevo Trabajador
                </a>
                
                {{-- Botón para ver trabajadores inactivos --}}
                <a href="{{ route('trabajadores.inactivos') }}"
                    class="bg-amber-100 hover:bg-amber-200 text-amber-700 px-5 py-3 rounded-xl font-semibold transition">
                    📦 Inactivos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalActivos = $trabajadores->count();

                $totalPlazoFijo = $trabajadores
                    ->where('tipo_contrato', 'plazo_fijo')
                    ->count();

                $totalIndefinidos = $trabajadores
                    ->where('tipo_contrato', 'indefinido')
                    ->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Trabajadores activos</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalActivos }}</p>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                            👥
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Contratos plazo fijo</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPlazoFijo }}</p>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl">
                            📄
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Contratos indefinidos</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalIndefinidos }}</p>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-2xl">
                            ♾️
                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================= --}}
            {{-- ALERTA DE ÉXITO --}}
            {{-- (Se muestra si venimos desde store() con success) --}}
            {{-- ========================= --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ========================= --}}
            {{-- BUSQUEDA POR RUT --}}
            {{-- ========================= --}}
            <form method="GET" action="{{ route('trabajadores.index') }}" class="mb-8">

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-5">

                    <div class="flex flex-col md:flex-row gap-4">

                        {{-- Buscador --}}
                        <div class="flex-1">

                            <input
                                type="text"
                                name="buscar"
                                value="{{ request('buscar') }}"
                                placeholder="🔍 Buscar por RUT, nombre o apellido..."
                                class="w-full border-gray-300 rounded-2xl px-5 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        {{-- Botones --}}
                        <div class="flex items-center gap-3">

                            <button
                                type="submit"
                                class="px-6 py-3 rounded-2xl bg-slate-700 hover:bg-slate-800 text-white font-semibold transition"
                            >
                                Buscar
                            </button>

                            <a
                                href="{{ route('trabajadores.index') }}"
                                class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition"
                            >
                                Limpiar
                            </a>

                        </div>

                    </div>

                </div>

            </form>


            {{-- ========================= --}}
            {{-- CONTENEDOR TABLA --}}
            {{-- ========================= --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">

                <table class="min-w-full divide-y divide-gray-200">

                    {{-- ========================= --}}
                    {{-- ENCABEZADO TABLA --}}
                    {{-- ========================= --}}
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Trabajador</th>                           
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Cargo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Contrato</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ingreso</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>

                    {{-- ========================= --}}
                    {{-- CUERPO TABLA --}}
                    {{-- ========================= --}}
                    <tbody class="bg-white divide-y divide-gray-200">

                        @forelse($trabajadores as $trabajador)

                            {{-- Fila --}}
                            <tr class="hover:bg-gray-50 transition">

                                {{-- Nombre completo (nombre + apellido) --}}
                                <td class="px-6 py-5">

                                    <div>

                                        <div class="font-semibold text-gray-900">
                                            👤 {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $trabajador->rut }}
                                        </div>

                                    </div>

                                </td>

                                {{-- Cargo --}}
                                <td class="px-6 py-4">
                                    @if($trabajador->cargo)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ $trabajador->cargo }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">
                                            Sin cargo
                                        </span>
                                    @endif
                                </td>

                                {{-- Tipo de contrato como badge (pastilla) --}}
                                <td class="px-6 py-4">
                                    @php
                                        // Guardamos el tipo de contrato en una variable para simplificar el bloque
                                        $tc = $trabajador->tipo_contrato;
                                    @endphp

                                    @if($tc === 'indefinido')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Indefinido
                                        </span>
                                    @elseif($tc === 'plazo_fijo')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Plazo fijo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            Sin definir
                                        </span>
                                    @endif
                                </td>

                                {{-- Fecha de ingreso formateada (si existe) --}}
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $trabajador->fecha_ingreso ? \Carbon\Carbon::parse($trabajador->fecha_ingreso)->format('d-m-Y') : '-' }}
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4">
                                    @if($trabajador->estado === 'vigente')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            🟢 Vigente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            🔴 No vigente
                                        </span>
                                    @endif
                                </td>

                                {{-- Acciones (por ahora son links, luego los conectamos a rutas reales) --}}
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <a href="{{ route('trabajadores.edit', $trabajador) }}"
                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                         ✏️ Editar
                                    </a>
                                </td>
                            </tr>

                        @empty

                            {{-- Mensaje cuando no hay registros --}}
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    No hay trabajadores vigentes registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

                {{-- Paginación --}}
                <div class="mt-8">
                    {{ $trabajadores->links() }}
                </div>
                
            </div>

        </div>
    </div>
</x-app-layout>