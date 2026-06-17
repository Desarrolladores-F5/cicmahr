<x-app-layout>
    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                📋 Historial de Actividad
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Consulta y audita todas las acciones realizadas dentro de la empresa.
            </p>

        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">   {{-- 💣 ANCHO DE LA CARD PPAL --}}

            {{-- 💣 CARD PRINCIPAL --}}
            <div class="bg-white border border-gray-100 shadow-md rounded-3xl overflow-hidden">

                {{-- 🔍 FILTROS --}}
                <div class="p-8 border-b border-gray-100 bg-white">

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                            🔎
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                Filtros del historial
                            </h3>

                            <p class="text-sm text-gray-500">
                                Busca actividades por módulo, usuario o rango de fechas.
                            </p>
                        </div>

                    </div>

                    <form method="GET" class="grid grid-cols-1 md:grid-cols-8 gap-4 items-end">

                        {{-- 🔍 Buscar --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Buscar
                            </label>

                            <input
                                type="text"
                                name="buscar"
                                value="{{ request('buscar') }}"
                                placeholder="Buscar en historial..."
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        {{-- 🎯 Módulo --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Módulo
                            </label>

                            <select
                                name="modulo"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Todos</option>

                                @foreach($modulos as $mod)
                                    <option value="{{ $mod }}" {{ request('modulo') == $mod ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ', $mod)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 👤 Usuario --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Usuario
                            </label>

                            <select
                                name="usuario"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Todos</option>

                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ request('usuario') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 📅 Desde --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Desde
                            </label>

                            <input
                                type="date"
                                name="fecha_desde"
                                value="{{ request('fecha_desde') }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        {{-- 📅 Hasta --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Hasta
                            </label>

                            <input
                                type="date"
                                name="fecha_hasta"
                                value="{{ request('fecha_hasta') }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        {{-- Botones --}}
                        <div class="md:col-span-2 flex items-end gap-3">

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-md transition"
                            >
                                🔍 Buscar
                            </button>

                            <a
                                href="{{ route('admin.historial.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition"
                            >
                                Limpiar
                            </a>

                        </div>

                    </form>

                </div>

                {{-- 📊 Estadísticas por día --}}
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                            📊
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Actividad por día
                            </h3>

                            <p class="text-sm text-gray-500">
                                Resumen de acciones registradas recientemente.
                            </p>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        @foreach($estadisticas as $stat)

                            <div class="bg-white border border-gray-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition">

                                <p class="text-sm font-medium text-gray-500">
                                    {{ \Carbon\Carbon::parse($stat->fecha)->format('d-m') }}
                                </p>

                                <p class="mt-2 text-3xl font-bold text-blue-600">
                                    {{ $stat->total }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    acciones
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- 📋 Historial detallado --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-md p-8 mt-8 mx-8 mb-8 overflow-hidden">

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-2xl">
                            📋
                        </div>

                        <div>

                            <h3 class="text-2xl font-bold text-gray-900">
                                Historial detallado
                            </h3>

                            <p class="text-sm text-gray-500">
                                Registro cronológico de todas las acciones realizadas en la plataforma.
                            </p>

                        </div>

                    </div>

                    <div class="border-t border-gray-100 pt-6">

                        {{-- 📊 TABLA --}}
                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-100">

                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                            Usuario
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                            Módulo
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                            Acción
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                            Descripción
                                        </th>

                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                            Fecha
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-100">

                                    @forelse($actividades as $actividad)

                                        @php
                                            $accion = trim(strtolower($actividad->accion));
                                            $critico = in_array($accion, ['eliminar', 'rechazar', 'inactivar']);
                                            $mod = strtolower($actividad->modulo);
                                        @endphp

                                        <tr class="{{ $critico ? 'bg-red-50 border-l-4 border-red-400 hover:bg-red-100' : 'hover:bg-gray-50' }} transition">

                                            {{-- Usuario --}}
                                            <td class="px-6 py-5">

                                                <div class="font-semibold text-gray-900">
                                                    👤 {{ $actividad->user->name ?? 'Sistema' }}
                                                </div>

                                                <div class="text-xs text-gray-500 mt-1">
                                                    Usuario responsable
                                                </div>

                                            </td>

                                            {{-- Módulo --}}
                                            <td class="px-6 py-5">

                                                @if($mod === 'trabajadores')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                        Trabajadores
                                                    </span>

                                                @elseif($mod === 'vacaciones')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                                        Vacaciones
                                                    </span>

                                                @elseif($mod === 'reglamentos')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        Reglamentos
                                                    </span>

                                                @elseif($mod === 'horas_extras')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                        Horas Extras
                                                    </span>

                                                @elseif($mod === 'administradores')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                        Admins
                                                    </span>

                                                @elseif($mod === 'documentos')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                                        Documentos
                                                    </span>

                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                        {{ ucfirst($actividad->modulo) }}
                                                    </span>
                                                @endif

                                            </td>

                                            {{-- Acción --}}
                                            <td class="px-6 py-5">

                                                @if($accion === 'crear')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        Crear
                                                    </span>

                                                @elseif($accion === 'editar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                        Editar
                                                    </span>

                                                @elseif($accion === 'eliminar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                        Eliminar
                                                    </span>

                                                @elseif($accion === 'aprobar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        Aprobar
                                                    </span>

                                                @elseif($accion === 'rechazar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                        Rechazar
                                                    </span>

                                                @elseif($accion === 'reactivar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                        Reactivar
                                                    </span>

                                                @elseif($accion === 'inactivar')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                        Inactivar
                                                    </span>

                                                @elseif($accion === 'visita')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-gray-600">
                                                        Visita
                                                    </span>

                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                        {{ ucfirst($accion) }}
                                                    </span>
                                                @endif

                                            </td>

                                            {{-- Descripción --}}
                                            <td class="px-6 py-5 text-sm text-gray-600 max-w-xl">
                                                {{ $actividad->descripcion }}
                                            </td>

                                            {{-- Fecha --}}
                                            <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $actividad->created_at->format('d-m-Y H:i') }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="5" class="px-6 py-14 text-center">

                                                <div class="text-5xl mb-4">
                                                    📭
                                                </div>

                                                <p class="font-semibold text-gray-800">
                                                    No hay actividad registrada
                                                </p>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    Cuando existan movimientos en la plataforma aparecerán aquí.
                                                </p>

                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>
                        </div>
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="border-t border-gray-100 p-6">
                        {{ $actividades->links() }}
                    </div>

                </div>
            </div>

            

        </div>
    </div>
</x-app-layout>