<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-between">

            <div>
                <h2 class="font-bold text-3xl text-gray-900 flex items-center gap-3">
                    👑 Crear Administrador
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Registra un nuevo administrador secundario para la empresa.
                </p>
            </div>

            <a href="{{ route('admin.administradores.index') }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl font-semibold transition">
                ← Volver
            </a>

        </div>
    </x-slot>


    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 p-4 text-red-800 border border-red-200 mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8">

                <div class="border-b border-gray-100 pb-5 mb-8">

                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                            🔐
                        </span>

                        Datos de acceso
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Define el nombre, correo y contraseña inicial del administrador.
                    </p>

                </div>


                <form method="POST" action="{{ route('admin.administradores.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmar contraseña
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>

                    <div class="pt-8 flex items-center gap-4">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-7 py-3 rounded-2xl shadow-md"
                        >
                            ✅ Crear Administrador
                        </button>

                        <a href="{{ route('admin.administradores.index') }}"
                           class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-7 py-3 rounded-2xl transition">
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>