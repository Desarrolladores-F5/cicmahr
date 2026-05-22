@extends('layouts.superadmin')

@section('content')

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- ENCABEZADO --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Gestión de Pagos
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Control financiero global de CicmaHR.
                </p>
            </div>

            <div class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                {{ $pagos->total() }} pagos
            </div>

        </div>

        {{-- KPIs --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- INGRESOS --}}
            <div class="bg-gray-900 text-white rounded-2xl shadow-sm p-6">

                <p class="text-sm text-gray-300">
                    Ingresos totales
                </p>

                <p class="text-3xl font-bold mt-2">
                    ${{ number_format($ingresosTotales, 0, ',', '.') }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Pagos exitosos registrados
                </p>

            </div>

            {{-- PAGOS PAGADOS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-6">

                <p class="text-sm text-gray-500">
                    Pagos pagados
                </p>

                <p class="text-3xl font-bold text-green-600 mt-2">
                    {{ $pagosPagados }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Confirmados correctamente
                </p>

            </div>

            {{-- PAGOS PENDIENTES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-6">

                <p class="text-sm text-gray-500">
                    Pagos pendientes
                </p>

                <p class="text-3xl font-bold text-yellow-600 mt-2">
                    {{ $pagosPendientes }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Requieren revisión
                </p>

            </div>

        </div>

        
       {{-- 🚨 RIESGO FINANCIERO --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- EMPRESAS MOROSAS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Empresas con pagos pendientes
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Riesgo financiero detectado
                            </p>
                        </div>

                        <div class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $empresasMorosas->count() }} pendientes
                        </div>

                    </div>

                </div>

                <div class="divide-y divide-gray-100">

                    @forelse($empresasMorosas as $pago)

                        <div class="px-6 py-4 flex items-center justify-between">

                            <div>

                                <p class="font-semibold text-gray-900">
                                    {{ $pago->empresa->nombre ?? 'Empresa no disponible' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Orden: {{ $pago->orden_compra ?? 'Sin orden' }}
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="font-bold text-yellow-600">
                                    ${{ number_format($pago->monto, 0, ',', '.') }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    Pendiente
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center text-gray-500">
                            No existen pagos pendientes.
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- TRIALS EXPIRADOS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Trials expirados
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Empresas activas fuera del trial
                            </p>
                        </div>

                        <div class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $trialsExpirados->count() }} expirados
                        </div>

                    </div>

                </div>

                <div class="divide-y divide-gray-100">

                    @forelse($trialsExpirados as $empresa)

                        <div class="px-6 py-4 flex items-center justify-between">

                            <div>

                                <p class="font-semibold text-gray-900">
                                    {{ $empresa->nombre }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Trial vencido
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="font-bold text-red-600">
                                    {{ optional($empresa->trial_hasta)->format('d-m-Y') }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    Expirado
                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center text-gray-500">
                            No existen trials expirados.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>     



        {{-- TABLA PAGOS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Orden
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Empresa
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Monto
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-left text-gray-500 font-semibold">
                                Fecha
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($pagos as $pago)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- ORDEN --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-900">
                                        {{ $pago->orden_compra ?? 'Sin orden' }}
                                    </div>

                                </td>

                                {{-- EMPRESA --}}
                                <td class="px-6 py-4 text-gray-700">

                                    {{ $pago->empresa->nombre ?? 'Sin empresa' }}

                                </td>

                                {{-- MONTO --}}
                                <td class="px-6 py-4 font-semibold text-gray-900">

                                    ${{ number_format($pago->monto, 0, ',', '.') }}

                                </td>

                                {{-- ESTADO --}}
                                <td class="px-6 py-4">

                                    @if($pago->estado === 'pagado')

                                        <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">
                                            Pagado
                                        </span>

                                    @elseif($pago->estado === 'pendiente')

                                        <span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-3 py-1 text-xs font-semibold">
                                            Pendiente
                                        </span>

                                    @elseif($pago->estado === 'fallido')

                                        <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-3 py-1 text-xs font-semibold">
                                            Fallido
                                        </span>

                                    @else

                                        <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-3 py-1 text-xs font-semibold">
                                            {{ ucfirst($pago->estado) }}
                                        </span>

                                    @endif

                                </td>

                                {{-- FECHA --}}
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">

                                    {{ optional($pago->created_at)->format('d-m-Y H:i') ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No existen pagos registrados.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINACIÓN --}}
        <div>
            {{ $pagos->links() }}
        </div>

    </div>

@endsection