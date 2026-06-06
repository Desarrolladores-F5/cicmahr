<x-app-layout>

    <div class="p-8">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-900">
                Mis Mensajes 📨
            </h1>

            <p class="mt-2 text-gray-500">
                Revisa las comunicaciones enviadas por tu empresa.
            </p>

        </div>

        @forelse($mensajes as $mensajeUser)

            <a
                href="{{ route('worker.mensajes.show', $mensajeUser) }}"
                class="block bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-6 hover:shadow-xl transition"
            >

                <div class="flex items-center justify-between mb-3">

                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $mensajeUser->mensaje->titulo }}
                    </h2>

                    @if($mensajeUser->leido)

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                            Leído
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                            Nuevo
                        </span>

                    @endif

                </div>

                <p class="text-gray-600 mb-4">
                    {{ $mensajeUser->mensaje->mensaje }}
                </p>

                <div class="text-sm text-gray-400">

                    {{ $mensajeUser->created_at->format('d/m/Y H:i') }}

                </div>

            </a>

        @empty

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-10 text-center">

                <p class="text-gray-500">
                    No tienes mensajes disponibles.
                </p>

            </div>

        @endforelse

    </div>

</x-app-layout>