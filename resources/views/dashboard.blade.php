<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel Administrativo CicmaHR
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Bienvenida -->
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Bienvenido, {{ Auth::user()->name }}
                </h3>
                <p class="text-gray-500 mt-1">
                    Gestiona tu empresa y trabajadores desde este panel.
                </p>
            </div>

            <!-- Información general -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500">Empresa</p>
                    <p class="text-lg font-semibold mt-1">
                        {{ Auth::user()->empresa->nombre ?? 'Sin empresa asignada' }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500">Plan contratado</p>
                    <p class="text-lg font-semibold mt-1 capitalize">
                        {{ Auth::user()->empresa->plan ?? 'N/A' }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500">Rol</p>
                    <p class="text-lg font-semibold mt-1 capitalize">
                        {{ str_replace('_', ' ', Auth::user()->rol) }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-xl p-5">
                    <p class="text-sm text-gray-500">Estado de cuenta</p>
                    <p class="text-lg font-semibold mt-1 capitalize">
                        {{ Auth::user()->empresa->estado ?? 'N/A' }}
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>