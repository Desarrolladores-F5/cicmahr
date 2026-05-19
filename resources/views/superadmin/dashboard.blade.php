@extends('layouts.superadmin')

@section('content')
    
    <div class="space-y-8">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Panel SuperAdmin — CicmaHR
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Vista global de empresas, pagos y actividad de la plataforma.
                </p>
            </div>

            <span class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-xs font-semibold text-white">
                Owner Panel
            </span>
        </div>

        <div class="max-w-7xl mx-auto space-y-8">
            

            {{-- MÉTRICAS PRINCIPALES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Empresas registradas</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEmpresas }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-6">
                    <p class="text-sm text-gray-500">Empresas activas</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $empresasActivas }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6">
                    <p class="text-sm text-gray-500">Empresas en trial</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $empresasEnTrial }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-6">
                    <p class="text-sm text-gray-500">Suspendidas</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $empresasSuspendidas }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-gray-900 text-white rounded-2xl shadow-sm p-6">
                    <p class="text-sm text-gray-300">Ingresos totales</p>
                    <p class="text-3xl font-bold mt-2">
                        ${{ number_format($ingresosTotales, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-indigo-200 p-6">
                    <p class="text-sm text-gray-500">Pagos registrados</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalPagos }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Trabajadores totales</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTrabajadores }}</p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ÚLTIMAS EMPRESAS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Últimas empresas registradas
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-3 text-gray-500">Empresa</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Plan</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Estado</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Creada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasEmpresas as $empresa)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-3 font-medium text-gray-800">
                                            {{ $empresa->nombre }}
                                        </td>
                                        <td class="py-3 px-3">
                                            {{ ucfirst($empresa->plan) }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-1 rounded-full text-xs
                                                @if($empresa->estado === 'activa') bg-green-100 text-green-700
                                                @else bg-red-100 text-red-700
                                                @endif">
                                                {{ ucfirst($empresa->estado) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-gray-500">
                                            {{ $empresa->created_at->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500">
                                            No hay empresas registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ÚLTIMOS PAGOS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Últimos pagos recibidos
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-3 text-gray-500">Empresa</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Monto</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Estado</th>
                                    <th class="text-left py-3 px-3 text-gray-500">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosPagos as $pago)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-3 font-medium text-gray-800">
                                            {{ $pago->empresa->nombre ?? 'Sin empresa' }}
                                        </td>
                                        <td class="py-3 px-3">
                                            ${{ number_format($pago->monto, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                                {{ ucfirst($pago->estado) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-gray-500">
                                            {{ optional($pago->fecha_pago)->format('d-m-Y H:i') ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500">
                                            No hay pagos registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection