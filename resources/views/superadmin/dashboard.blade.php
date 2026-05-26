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

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

                {{-- 💰 MRR --}}
                <div class="bg-gray-900 text-white rounded-2xl shadow-sm p-6">
                    <p class="text-sm text-gray-300">
                        MRR Actual
                    </p>

                    <p class="text-3xl font-bold mt-2">
                        ${{ number_format($mrr, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Ingresos recurrentes del mes
                    </p>
                </div>

                {{-- 💳 PAGOS PENDIENTES --}}
                <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-6">
                    <p class="text-sm text-gray-500">
                        Pagos pendientes
                    </p>

                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ $pagosPendientes }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Requieren seguimiento
                    </p>
                </div>

                {{-- 🏢 NUEVAS EMPRESAS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-6">
                    <p class="text-sm text-gray-500">
                        Nuevas empresas
                    </p>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $nuevasEmpresasMes }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Registradas este mes
                    </p>
                </div>

                {{-- 👷 NUEVOS TRABAJADORES --}}
                <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6">
                    <p class="text-sm text-gray-500">
                        Nuevos trabajadores
                    </p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $nuevosTrabajadoresMes }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Ingresados este mes
                    </p>
                </div>

            </div>


            {{-- 📊 ANALYTICS AVANZADO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

                {{-- 📉 CHURN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-6">

                    <p class="text-sm text-gray-500">
                        Churn Rate
                    </p>

                    <p class="text-3xl font-bold text-red-600 mt-2">
                        {{ $churnRate }}%
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Empresas suspendidas
                    </p>

                </div>

                {{-- 💰 ARPU --}}
                <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-6">

                    <p class="text-sm text-gray-500">
                        ARPU
                    </p>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        ${{ number_format($arpu, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Ingreso promedio por empresa
                    </p>

                </div>

                {{-- 📈 GROWTH --}}
                <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6">

                    <p class="text-sm text-gray-500">
                        Growth mensual
                    </p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $growthRate }}%
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Crecimiento empresas
                    </p>

                </div>

                {{-- 🚀 TRIAL CONVERSION --}}
                <div class="bg-white rounded-2xl shadow-sm border border-purple-200 p-6">

                    <p class="text-sm text-gray-500">
                        Trial Conversion
                    </p>

                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        {{ $trialConversion }}%
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Trials convertidos a pago
                    </p>

                </div>

            </div>


            {{-- 📈 GRÁFICOS --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

                {{-- CRECIMIENTO EMPRESAS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Crecimiento de empresas
                            </h3>

                            <p class="text-sm text-gray-500">
                                Últimos 6 meses
                            </p>
                        </div>

                    </div>

                    <canvas id="empresasChart" height="120"></canvas>

                </div>

                {{-- INGRESOS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                    <div class="flex items-center justify-between mb-6">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Ingresos mensuales
                            </h3>

                            <p class="text-sm text-gray-500">
                                Pagos registrados
                            </p>
                        </div>

                    </div>

                    <canvas id="ingresosChart" height="120"></canvas>

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

    {{-- SCRIPT DE GRÁFICOS --}}
    <script>
        window.addEventListener('load', function () {
            const empresasLabels = @json(collect($empresasPorMes)->pluck('mes'));
            const empresasData = @json(collect($empresasPorMes)->pluck('total'));

            const ingresosLabels = @json(collect($ingresosPorMes)->pluck('mes'));
            const ingresosData = @json(collect($ingresosPorMes)->pluck('total'));

            new window.Chart(document.getElementById('empresasChart'), {
                type: 'line',
                data: {
                    labels: empresasLabels,
                    datasets: [{
                        label: 'Empresas',
                        data: empresasData,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true
                }
            });

            new window.Chart(document.getElementById('ingresosChart'), {
                type: 'bar',
                data: {
                    labels: ingresosLabels,
                    datasets: [{
                        label: 'Ingresos',
                        data: ingresosData
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>

@endsection
