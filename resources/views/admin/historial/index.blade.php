<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de Actividad
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">   {{-- 💣 ANCHO DE LA CARD PPAL --}}

            {{-- 💣 CARD PRINCIPAL --}}
            <div class="bg-white border border-gray-200 shadow rounded-xl overflow-hidden">

                {{-- 🔍 FILTROS --}}
                <div class="p-4 border-b bg-gray-50 flex flex-col md:flex-row gap-4 justify-between">

                    <form method="GET" class="flex flex-col md:flex-row gap-2 w-full items-start md:items-center">

                        {{-- 🔍 Buscar --}}
                        <input type="text" name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar en historial..."
                            class="border rounded-lg px-3 py-2 text-sm">

                        {{-- 🎯 Módulo --}}
                        <select name="modulo" class="border rounded-lg px-3 py-2 text-sm">
                            <option value="">Todos los módulos</option>
                            @foreach($modulos as $mod)
                                <option value="{{ $mod }}" {{ request('modulo') == $mod ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_',' ', $mod)) }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 👤 Usuario --}}
                        <select name="usuario" class="border rounded-lg px-3 py-2 text-sm">
                            <option value="">Todos los usuarios</option>
                            @foreach($usuarios as $user)
                                <option value="{{ $user->id }}" {{ request('usuario') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 📅 Desde --}}
                        <input type="date" name="fecha_desde"
                            value="{{ request('fecha_desde') }}"
                            class="border rounded-lg px-3 py-2 text-sm">

                        {{-- 📅 Hasta --}}
                        <input type="date" name="fecha_hasta"
                            value="{{ request('fecha_hasta') }}"
                            class="border rounded-lg px-3 py-2 text-sm">

                        {{-- 🔍 Botón buscar --}}
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                            Buscar
                        </button>

                        {{-- ♻️ Limpiar --}}
                        <a href="{{ route('admin.historial.index') }}"
                            class="bg-gray-200 px-4 py-2 rounded-lg text-sm">
                            Limpiar
                        </a>

                    </form>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 px-4 pt-4">

                    @foreach($estadisticas as $stat)
                        <div class="bg-white border rounded-lg p-3 text-center">
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($stat->fecha)->format('d-m') }}
                            </p>

                            <p class="text-xl font-bold text-blue-600">
                                {{ $stat->total }}
                            </p>

                            <p class="text-xs text-gray-400">
                                acciones
                            </p>
                        </div>
                    @endforeach

                </div>

                {{-- 📊 TABLA --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Usuario</th>
                                <th class="px-6 py-3 text-left">Módulo</th>
                                <th class="px-6 py-3 text-left">Acción</th>
                                <th class="px-6 py-3 text-left">Descripción</th>
                                <th class="px-6 py-3 text-left">Fecha</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($actividades as $actividad)
                                @php
                                    $accion = trim(strtolower($actividad->accion));
                                    $critico = in_array($accion, ['eliminar', 'rechazar', 'inactivar']);
                                    $mod = strtolower($actividad->modulo);
                                @endphp

                                <tr class="{{ $critico ? 'bg-red-50 border-l-4 border-red-400 hover:bg-red-100' : 'hover:bg-gray-50' }}">

                                    <td class="px-6 py-4 text-sm">
                                        {{ $actividad->user->name ?? 'Sistema' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $mod = strtolower($actividad->modulo);
                                        @endphp

                                        @if($mod === 'trabajadores')
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Trabajadores</span>

                                        @elseif($mod === 'vacaciones')
                                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">Vacaciones</span>

                                        @elseif($mod === 'reglamentos')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Reglamentos</span>

                                        @elseif($mod === 'horas_extras')
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Horas Extras</span>

                                        @elseif($mod === 'administradores')
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Admins</span>

                                        @elseif($mod === 'documentos')
                                            <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">Documentos</span>

                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                                {{ ucfirst($actividad->modulo) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm">

                                        @if($accion === 'crear')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                                Crear
                                            </span>

                                        @elseif($accion === 'editar')
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">
                                                Editar
                                            </span>

                                        @elseif($accion === 'eliminar')
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                                                Eliminar
                                            </span>

                                        @elseif($accion === 'aprobar')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                                Aprobar
                                            </span>

                                        @elseif($accion === 'rechazar')
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                                                Rechazar
                                            </span>

                                        @elseif($accion === 'reactivar')
                                            <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-medium">
                                                Reactivar
                                            </span>

                                        @elseif($accion === 'inactivar')
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                                                Inactivar
                                            </span>

                                        @elseif($accion === 'visita')
                                            <span class="bg-yellow-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">
                                                Visita
                                            </span>

                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                                {{ ucfirst($accion) }}
                                            </span>
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $actividad->descripcion }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $actividad->created_at->format('d-m-Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">
                                        No hay actividad registrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            {{-- PAGINACIÓN --}}
            <div class="p-4">
                {{ $actividades->links() }}
            </div>

        </div>
    </div>
</x-app-layout>