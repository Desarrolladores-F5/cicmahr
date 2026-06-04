<x-app-layout>

    <div class="p-8">

        <h1 class="text-3xl font-bold text-gray-900">
            Mensajes ✉️
        </h1>

        <p class="mt-2 text-gray-500">
            Módulo de mensajería interna en construcción.
        </p>

        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.mensajes.create') }}"
           class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
            Nuevo mensaje
        </a>

    </div>

</x-app-layout>