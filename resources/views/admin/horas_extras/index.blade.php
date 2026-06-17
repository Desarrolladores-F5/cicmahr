<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-900 flex items-center gap-3">
                ⏱️ Horas Extras
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Gestiona las horas extraordinarias de
                <span class="font-semibold text-gray-700">
                    {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                </span>.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-lg bg-green-50 p-3 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-3 text-red-800 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Resumen horas extras --}}
            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">

                <div class="border-b border-gray-100 pb-5 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                            ⏱️
                        </span>

                        Resumen Horas Extras
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Resumen mensual y cálculo estimado del trabajador.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Total horas --}}
                    <div class="rounded-3xl bg-blue-50 p-6 border border-blue-100">
                        <p class="text-sm font-semibold text-blue-700">
                            Horas del mes
                        </p>

                        <p class="mt-3 text-4xl font-bold text-blue-700">
                            {{ $totalMesActual }}
                            <span class="text-lg font-semibold">
                                horas
                            </span>
                        </p>
                    </div>

                    {{-- Valores legales --}}
                    <div class="rounded-3xl bg-indigo-50 p-6 border border-indigo-100">
                        <p class="text-sm font-semibold text-indigo-700">
                            Valores de cálculo
                        </p>

                        <div class="mt-4 space-y-2 text-sm text-indigo-900">
                            <p>
                                Valor hora normal:
                                <span class="font-bold">
                                    ${{ number_format($valorHora,0,',','.') }}
                                </span>
                            </p>

                            <p>
                                Valor hora extra:
                                <span class="font-bold">
                                    ${{ number_format($valorHoraExtra,0,',','.') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Total estimado --}}
                    <div class="rounded-3xl bg-emerald-50 p-6 border border-emerald-100">
                        <p class="text-sm font-semibold text-emerald-700">
                            Total estimado
                        </p>

                        <p class="mt-3 text-4xl font-bold text-emerald-700">
                            ${{ number_format($montoHorasExtras,0,',','.') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Formulario registrar horas extras --}}
            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">

                <div class="border-b border-gray-100 pb-5 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-xl">
                            ➕
                        </span>

                        Registrar Horas Extras
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Ingresa las horas extraordinarias realizadas por el trabajador.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.horas_extras.store', $trabajador) }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha
                            </label>

                            <input
                                type="date"
                                name="fecha"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cantidad de horas
                            </label>

                            <input
                                type="number"
                                name="horas"
                                step="0.5"
                                min="0.5"
                                max="2"
                                placeholder="Ej: 1.5"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >

                            
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Motivo
                            </label>

                            <input
                                type="text"
                                name="motivo"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ej: cierre de caja, inventario, contingencia..."
                            >
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 shadow-md transition"
                            >
                                ➕ Registrar horas
                            </button>
                        </div>

                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">
                            ℹ️ Máximo permitido por día: 2 horas.
                        </p>
                    </div>

                </form>

            </div>

            {{-- Tabla historial --}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <div class="border-b border-gray-100 pb-5 mb-6">

                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">

                        <span class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                            📋
                        </span>

                        Historial de Horas Extras

                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Revisa y administra las horas extraordinarias registradas para este trabajador.
                    </p>

                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Registro
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Motivo
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Estado
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Registrado por
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse($horasExtras as $hora)

                                <tr>

                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($hora->fecha)->format('d-m-Y') }}
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $hora->horas }} hrs
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-gray-700 max-w-xs">
                                        {{ $hora->motivo ?? 'Sin observaciones' }}
                                    </td>

                                    <td class="px-4 py-3">

                                        @if($hora->estado === 'pendiente')
                                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">
                                                Pendiente
                                            </span>

                                        @elseif($hora->estado === 'aprobado')
                                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                                                Aprobado
                                            </span>

                                        @elseif($hora->estado === 'rechazado')
                                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">
                                                Rechazado
                                            </span>
                                        @endif

                                    </td>

                                    <td class="px-4 py-4">

                                        <div class="font-medium text-gray-900">
                                            👤 {{ $hora->registradoPor->name ?? '-' }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Administrador
                                        </div>

                                    </td>

                                    <td class="px-4 py-3">

                                        @if($hora->estado === 'pendiente')

                                            <div class="flex items-center gap-2">

                                                {{-- APROBAR --}}
                                                <form method="POST"
                                                    action="{{ route('admin.horas_extras.aprobar', $hora) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold hover:bg-emerald-100 transition">
                                                        ✅ Aprobar
                                                    </button>
                                                </form>

                                                {{-- RECHAZAR --}}
                                                <form method="POST"
                                                    action="{{ route('admin.horas_extras.rechazar', $hora) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 transition">
                                                        ❌ Rechazar
                                                    </button>
                                                </form>

                                            </div>

                                        @else

                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">
                                                🔒 Procesado
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6"
                                        class="px-4 py-6 text-center text-gray-500">

                                        No hay horas extras registradas.

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>