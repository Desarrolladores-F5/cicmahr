<x-app-layout>

   <x-slot name="header">

        <div class="flex items-start justify-between">

            {{-- Título --}}
            <div>

                <h2 class="font-bold text-3xl text-gray-900 flex items-center gap-3">
                    ⏱️ Administración de Horas Extras
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Controla y administra las horas extraordinarias registradas en la empresa.
                </p>

            </div>


            {{-- Resumen --}}
            <div class="bg-blue-600 text-white px-8 py-4 rounded-2xl shadow-md flex items-center gap-8">

                <div>
                    <p class="text-xs opacity-80 uppercase tracking-wide">
                        Horas extras mes
                    </p>

                    <p class="text-3xl font-bold">
                        {{ number_format($totalHorasEmpresaMes,1) }}
                        <span class="text-lg font-medium opacity-80">
                            hrs
                        </span>
                    </p>
                </div>

                <div class="border-l border-blue-400 h-10"></div>

                <div>
                    <p class="text-xs opacity-80 uppercase tracking-wide">
                        Costo estimado
                    </p>

                    <p class="text-3xl font-bold">
                        ${{ number_format($costoTotalEstimado,0,',','.') }}
                    </p>
                </div>

            </div>

        </div>

    </x-slot>   

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">

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
                        <tr class="hover:bg-gray-50 transition">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Trabajador
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Horas del mes
                            </th>
                            
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach($trabajadores as $trabajador)

                        <tr>

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

                            <td class="px-4 py-3">
                                @if(($trabajador->horas_mes_actual ?? 0) > 0)
                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                        {{ number_format($trabajador->horas_mes_actual ?? 0, 1, '.', '') }} hrs
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                        0 hrs
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">

                                <a href="{{ route('admin.horas_extras.index', $trabajador) }}"
                                   class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">

                                    Gestionar horas

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