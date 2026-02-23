<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Trabajador
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-xl p-6">

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('trabajadores.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" name="nombre" class="w-full border rounded p-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Apellido</label>
                        <input type="text" name="apellido" class="w-full border rounded p-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">RUT</label>
                        <input type="text" name="rut" class="w-full border rounded p-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Cargo</label>
                        <input type="text" name="cargo" class="w-full border rounded p-2 mt-1">
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow mt-4">
                        Registrar Trabajador
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>