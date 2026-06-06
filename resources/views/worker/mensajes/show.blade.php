<x-app-layout>

    <div class="p-8">

        <div class="mb-8">

            <a
                href="{{ route('worker.mensajes.index') }}"
                class="text-[#0369A1] hover:underline font-medium"
            >
                ← Volver a Mis Mensajes
            </a>

        </div>

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

            <div class="flex items-center justify-between mb-6">

                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $mensajeUser->mensaje->titulo }}
                </h1>

                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                    Leído
                </span>

            </div>

            <div class="border-t border-gray-100 pt-6">

                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $mensajeUser->mensaje->mensaje }}
                </p>

            </div>

            <div class="mt-8 text-sm text-gray-400">

                Enviado:
                {{ $mensajeUser->mensaje->created_at->format('d/m/Y H:i') }}

            </div>

            @if($mensajeUser->fecha_lectura)

                <div class="mt-2 text-sm text-green-600">

                    Leído:
                    {{ $mensajeUser->fecha_lectura->format('d/m/Y H:i') }}

                </div>

            @endif

        </div>

    </div>

</x-app-layout>