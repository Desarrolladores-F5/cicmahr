<x-app-layout>

    <div class="p-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <h1 class="text-4xl font-bold text-gray-900">
                Mi Suscripción 💳
            </h1>

            <p class="mt-2 text-gray-500">
                Consulta el estado actual de tu suscripción y tu historial de pagos.
            </p>

        </div>

        {{-- RESUMEN --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            {{-- ESTADO --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">

                <p class="text-sm text-gray-500">
                    Estado
                </p>

                <h2 class="text-3xl font-bold mt-2
                    {{ $empresa->suscripcion_activa
                        ? 'text-green-600'
                        : 'text-red-600' }}">
                    {{ $empresa->suscripcion_activa ? 'Activa' : 'Suspendida' }}
                </h2>

            </div>

            {{-- PLAN CONTRATADO --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">

                <p class="text-sm text-gray-500">
                    Plan Contratado
                </p>

                <h2 class="text-2xl font-bold mt-2 text-indigo-600">
                    {{ $nombrePlan }}
                </h2>

            </div>

            {{-- VENCIMIENTO --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">

                <p class="text-sm text-gray-500">
                    Vence el
                </p>

                <h2 class="text-2xl font-bold mt-2 text-gray-900">
                    {{ $empresa->suscripcion_hasta
                        ? $empresa->suscripcion_hasta->format('d/m/Y')
                        : '-' }}
                </h2>

            </div>

            {{-- DIAS RESTANTES --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">

                <p class="text-sm text-gray-500">
                    Días restantes
                </p>

                <h2 class="text-3xl font-bold mt-2 text-blue-600">
                    {{ $diasRestantes ?? '-' }}
                </h2>

            </div>

        </div>

        {{-- ULTIMO PAGO --}}
        <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100 mb-8">

            <h2 class="text-2xl font-bold mb-6">
                Último Pago
            </h2>

            @if($ultimoPago)

                <div class="grid md:grid-cols-3 gap-6">

                    <div>

                        <p class="text-sm text-gray-500">
                            Monto
                        </p>

                        <p class="text-2xl font-bold">
                            ${{ number_format($ultimoPago->monto, 0, ',', '.') }}
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Período
                        </p>

                        <p class="text-2xl font-bold">
                            {{ $ultimoPago->periodo_meses }} Mes(es)
                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Fecha
                        </p>

                        <p class="text-2xl font-bold">
                            {{ $ultimoPago->fecha_pago?->format('d/m/Y') }}
                        </p>

                    </div>

                </div>

            @else

                <p class="text-gray-500">
                    No existen pagos registrados.
                </p>

            @endif

        </div>

        {{-- BOTON RENOVAR --}}
        <div class="mb-10">

            <a href="{{ route('planes.index') }}"
            class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl
                    bg-gradient-to-r from-blue-600 to-indigo-600
                    text-white font-semibold shadow-lg
                    hover:shadow-xl hover:-translate-y-1 transition-all">

                🚀 Renovar Suscripción

            </a>

        </div>

        {{-- HISTORIAL --}}
        <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-100">

            <h2 class="text-2xl font-bold mb-6">
                Historial de Pagos
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">Fecha</th>
                            <th class="text-left py-3">Período</th>
                            <th class="text-left py-3">Monto</th>
                            <th class="text-left py-3">Estado</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($pagos as $pago)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="py-4">
                                    {{ $pago->fecha_pago?->format('d/m/Y') }}
                                </td>

                                <td class="py-4">
                                    {{ $pago->periodo_meses }} Mes(es)
                                </td>

                                <td class="py-4">
                                    ${{ number_format($pago->monto, 0, ',', '.') }}
                                </td>

                                <td class="py-4">

                                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                                        {{ ucfirst($pago->estado) }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="py-6 text-center text-gray-500">
                                    No existen pagos registrados.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>