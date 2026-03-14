<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
        Mis Horas Extras
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">

        {{-- RESUMEN --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">

            <div class="flex items-center justify-between mb-4">

                <h3 class="text-xl font-semibold text-blueb-800">
                    Resumen de {{ now()->translatedFormat('F Y') }}
                </h3>

                <div class="text-3xl">
                    ⏱
                </div>

                </div>

                <div class="text-3xl font-bold text-blue-600 mb-4">
                    {{ number_format($totalMesActual,1) }} horas
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

                    <div class="bg-white rounded-lg p-3 border">
                        <p class="text-gray-500">Valor hora normal</p>
                        <p class="font-semibold text-xl mt-1">${{ number_format($valorHora,0,',','.') }}</p> 
                    </div>

                    <div class="bg-white rounded-lg p-3 border">
                        <p class="text-gray-500">Valor hora extra</p>
                        <p class="font-semibold text-xl mt-1">${{ number_format($valorHoraExtra,0,',','.') }}</p>
                    </div>

                    <div class="bg-white rounded-lg p-3 border">
                        <p class="text-gray-500">Monto estimado</p>
                        <p class="font-semibold text-green-600 text-xl mt-1">
                        ${{ number_format($montoHorasExtras,0,',','.') }}
                    </p>
                </div>

            </div>

        </div>

        {{-- HISTORIAL --}}
    
        <div class="bg-white shadow rounded-xl p-6">

            <h3 class="text-lg font-semibold mb-4">
                Historial de horas extras
            </h3>

            <table class="w-full text-sm text-left">

                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="py-2">Fecha</th>
                        <th class="py-2">Horas</th>
                        <th class="py-2">Motivo</th>
                        <th class="py-2">Estado</th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($horasExtras as $hora)

                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">
                                {{ \Carbon\Carbon::parse($hora->fecha)->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                    {{ $hora->horas }} hrs
                                </span>
                            </td>

                            <td>
                                {{ $hora->motivo }}
                            </td>

                            <td>
                                @if($hora->estado == 'aprobado')
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Aprobado
                                    </span>
                                @elseif($hora->estado == 'pendiente')
                                    <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                        Pendiente
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                        Rechazado
                                    </span>
                                @endif
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                No tienes horas extras registradas este mes.
                            </td>
                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>
