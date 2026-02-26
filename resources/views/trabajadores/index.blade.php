<x-app-layout>
    {{-- ========================= --}}
    {{-- HEADER (Título + Botón) --}}
    {{-- ========================= --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trabajadores
            </h2>

            <div class="flex items-center gap-3">

                {{-- Botón para ir al dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                    ← Dashboard
                </a>
                {{-- Botón para descargar nómina en Excel --}}
                <a href="{{ route('trabajadores.export.excel') }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 transition text-white px-4 py-2 rounded-lg shadow">
                    Exportar Excel
                </a>

                {{-- Botón para crear trabajador --}}
                <a href="{{ route('trabajadores.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded-lg shadow">
                    + Nuevo Trabajador
                </a>
                
                {{-- Botón para ver trabajadores inactivos --}}
                <a href="{{ route('trabajadores.inactivos') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                    Ver Inactivos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
            <form method="GET" action="{{ route('trabajadores.index') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <input type="text"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar por RUT, nombre o apellido..."
                        class="border rounded-lg px-4 py-2">

                    <select name="estado" class="border rounded-lg px-4 py-2">
                        <option value="">Estado</option>
                        <option value="vigente" @selected(request('estado')=='vigente')>Vigente</option>
                        <option value="no_vigente" @selected(request('estado')=='no_vigente')>No Vigente</option>
                    </select>

                    <select name="tipo_contrato" class="border rounded-lg px-4 py-2">
                        <option value="">Tipo contrato</option>
                        <option value="plazo_fijo" @selected(request('tipo_contrato')=='plazo_fijo')>Plazo fijo</option>
                        <option value="indefinido" @selected(request('tipo_contrato')=='indefinido')>Indefinido</option>
                    </select>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
                            Buscar
                        </button>

                        <a href="{{ route('trabajadores.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Limpiar
                        </a>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">RUT</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Cargo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Contrato</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ingreso</th>
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
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ trim($trabajador->nombre . ' ' . $trabajador->apellido) }}
                                </td>

                                {{-- RUT --}}
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $trabajador->rut }}
                                </td>

                                {{-- Cargo --}}
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $trabajador->cargo ?? '-' }}
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

                                {{-- Acciones (por ahora son links, luego los conectamos a rutas reales) --}}
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <a href="{{ route('trabajadores.edit', $trabajador) }}"
                                        class="text-blue-600 hover:underline">
                                         Editar
                                    </a>

                                    <a href="#"
                                       class="text-red-600 hover:text-red-800 font-medium">
                                        Eliminar
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
            </div>

        </div>
    </div>
</x-app-layout>