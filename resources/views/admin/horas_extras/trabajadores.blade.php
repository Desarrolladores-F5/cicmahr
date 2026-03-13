<x-app-layout>

   <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administración Horas Extras
            </h2>

            <div class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-md flex items-center gap-6">

                <div>
                    <p class="text-xs opacity-80">Horas extras mes</p>
                    <p class="text-lg font-bold">
                        {{ number_format($totalHorasEmpresaMes,2) }} hrs
                    </p>
                </div>

                <div class="border-l border-blue-400 h-8"></div>

                <div>
                    <p class="text-xs opacity-80">Costo estimado</p>
                    <p class="text-lg font-bold">
                        ${{ number_format($costoTotalEstimado,0,',','.') }}
                    </p>
                </div>

            </div>

        </div>
    </x-slot>    

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Seleccionar trabajador
                    </h3>

                    <a href="{{ route('admin.horas_extras.export') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        Exportar Excel del mes
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nombre</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">RUT</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Horas del Mes</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach($trabajadores as $trabajador)

                        <tr>

                            <td class="px-4 py-3">
                                {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trabajador->rut }}
                            </td>

                            <td class="px-4 py-3">
                                @if(($trabajador->horas_mes_actual ?? 0) > 0)
                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                        {{ number_format($trabajador->horas_mes_actual ?? 0, 1, '.', '') }} hrs
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">0</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">

                                <a href="{{ route('admin.horas_extras.index', $trabajador) }}"
                                   class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700">

                                    Ver horas extras

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>