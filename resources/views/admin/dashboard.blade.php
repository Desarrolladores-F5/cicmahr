<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel Admin — CicmaHR
        </h2>
    </x-slot>

    {{-- --- ACA EMPIEZA EL CONTENIDO PRINCIPAL DEL DASHBOARD -- ---}}
    <div class="py-10">           
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- MÉTRICAS SUPERIORES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Plan Actual</p>
                    <p class="text-2xl font-semibold capitalize">
                        {{ $empresa->plan }}
                    </p>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Trabajadores</p>
                    <p class="text-2xl font-semibold">
                        {{ $totalTrabajadores }} / {{ $limite }}
                    </p>

                    @if($totalTrabajadores >= $limite)
                        <span class="text-red-600 text-sm font-medium">
                            Límite alcanzado
                        </span>
                    @endif
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Estado del Plan</p>
                    <p class="text-2xl font-semibold text-green-600">
                        Activo
                    </p>
                </div>

            </div>

            {{-- ACCIONES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">

                <a href="{{ route('trabajadores.index') }}"
                class="bg-white hover:shadow-lg transition rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Gestión de Trabajadores</h3>
                    <p class="text-gray-500 text-sm">
                        Ver, editar y eliminar trabajadores registrados.
                    </p>
                </a>

                <a href="{{ route('trabajadores.create') }}"
                class="bg-white hover:shadow-lg transition rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Crear Trabajador</h3>
                    <p class="text-gray-500 text-sm">
                        Registrar un nuevo trabajador en la empresa.
                    </p>
                </a>

                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-70 cursor-not-allowed">
                    <h3 class="text-lg font-semibold mb-2">Trabajadores Inactivos</h3>
                    <p class="text-gray-500 text-sm">
                        Próximamente: Ver trabajadores inactivos registrados.
                    </p>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-70 cursor-not-allowed">
                    <h3 class="text-lg font-semibold mb-2">Crear Administradores</h3>
                    <p class="text-gray-500 text-sm">
                        Próximamente: Gestión de múltiples administradores.
                    </p>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-70 cursor-not-allowed">
                    <h3 class="text-lg font-semibold mb-2">Historial de Registros</h3>
                    <p class="text-gray-500 text-sm">
                        Próximamente: Registro de todas las acciones realizadas.
                    </p>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-70 cursor-not-allowed">
                    <h3 class="text-lg font-semibold mb-2">Búsqueda Avanzada</h3>
                    <p class="text-gray-500 text-sm">
                        Próximamente: Búsqueda avanzada de trabajadores.
                    </p>
                </div>

                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200 opacity-70 cursor-not-allowed">
                    <h3 class="text-lg font-semibold mb-2">Actualice su Plan</h3>
                    <p class="text-gray-500 text-sm">
                        Próximamente: Actualización de planes de suscripción.
                    </p>
                </div>

            </div>

        </div>
    </div>    
</x-app-layout>