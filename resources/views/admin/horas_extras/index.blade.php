<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Horas extras — {{ $trabajador->nombre }} {{ $trabajador->apellido }}
        </h2>
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

            {{-- Total mensual --}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">
                    Total horas extras del mes actual
                </h3>

                <p class="text-3xl font-bold text-blue-600">
                    {{ $totalMesActual }} horas
                </p>
            </div>

            {{-- Calculo Hora Extras --}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 mt-4">

                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                    Cálculo estimado horas extras
                </h3>

                <p class="text-gray-600">
                    Valor hora normal:
                    <strong>${{ number_format($valorHora,0,',','.') }}</strong>
                </p>

                <p class="text-gray-600">
                    Valor hora extra:
                    <strong>${{ number_format($valorHoraExtra,0,',','.') }}</strong>
                </p>

                <p class="text-lg font-bold text-green-600 mt-2">
                    Total estimado horas extras:
                    ${{ number_format($montoHorasExtras,0,',','.') }}
                </p>

            </div>

            {{-- Formulario registrar horas extras --}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    Registrar horas extras
                </h3>

                <form method="POST" action="{{ route('admin.horas_extras.store', $trabajador) }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date"
                                   name="fecha"
                                   class="w-full border rounded-lg p-2 mt-1"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Horas</label>
                            <input type="number"
                                   name="horas"
                                   step="0.5"
                                   min="0.5"
                                   max="2"
                                   class="w-full border rounded-lg p-2 mt-1"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Motivo</label>
                            <input type="text"
                                   name="motivo"
                                   class="w-full border rounded-lg p-2 mt-1"
                                   placeholder="Ej: cierre inventario">
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                                Registrar
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Tabla historial --}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    Historial de horas extras
                </h3>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado por</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($horasExtras as $hora)
                                <tr>
                                    <td class="px-4 py-3">{{ $hora->fecha }}</td>
                                    <td class="px-4 py-3">{{ $hora->horas }}</td>
                                    <td class="px-4 py-3">{{ $hora->motivo ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $hora->registradoPor->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
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