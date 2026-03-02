<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Administrador
            </h2>

            <a href="{{ route('admin.administradores.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-4 text-red-800 border border-red-200 mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-xl p-6 space-y-5">
                <form method="POST" action="{{ route('admin.administradores.store') }}">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded-lg p-2 mt-1">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border rounded-lg p-2 mt-1">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Contraseña</label>
                        <input type="password" name="password"
                               class="w-full border rounded-lg p-2 mt-1">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border rounded-lg p-2 mt-1">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-6 py-2 rounded-lg shadow">
                            Crear Administrador
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>