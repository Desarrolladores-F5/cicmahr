<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Trabajador
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">                  
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

                    <div class="space-y-10">

                        {{-- ===================== --}}
                        {{-- DATOS PERSONALES --}}
                        {{-- ===================== --}}
                        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                Datos Personales
                            </h3>

                            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Apellido</label>
                                    <input type="text" name="apellido" value="{{ old('apellido') }}"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RUT</label>
                                    <input type="text" name="rut" value="{{ old('rut') }}"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Dirección</label>
                                    <input type="text" name="direccion" value="{{ old('direccion') }}"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div class="mt-4">                                    
                                    <x-input-label for="email" :value="__('Email del trabajador')" />

                                    <x-text-input id="email"
                                        class="block mt-1 w-full"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        autocomplete="email"
                                        placeholder="trabajador@empresa.cl" />

                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />                                    

                                    <p class="text-xs text-gray-500 mt-1">
                                        Opcional. Este correo podrá usarse luego para crear acceso al Portal del Trabajador.
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- DATOS LABORALES --}}
                        {{-- ===================== --}}
                        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                Datos Laborales
                            </h3>

                            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cargo</label>
                                    <input type="text" name="cargo" value="{{ old('cargo') }}"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sueldo</label>
                                    <input type="number" step="0.01" name="sueldo" value="{{ old('sueldo', $trabajador->sueldo ?? '') }}"
                                        placeholder="Ej: 750000"
                                        class="w-full border rounded-lg p-2 mt-1 placeholder-gray-400">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de Contrato</label>
                                    <select name="tipo_contrato"
                                        class="w-full border rounded-lg p-2 mt-1">
                                        <option value="">Seleccione</option>
                                        <option value="plazo_fijo">Plazo Fijo</option>
                                        <option value="indefinido">Indefinido</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select name="estado"
                                        class="w-full border rounded-lg p-2 mt-1">
                                        <option value="vigente">Vigente</option>
                                        <option value="no_vigente">No Vigente</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- FECHAS Y JORNADA --}}
                        {{-- ===================== --}}
                        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">
                                Fechas y Jornada
                            </h3>

                            <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                                    <input type="date" name="fecha_ingreso"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                                    <input type="date" name="fecha_salida"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Horario</label>
                                    <input type="text" name="horario"
                                        class="w-full border rounded-lg p-2 mt-1">
                                </div>

                            </div>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                                Registrar Trabajador
                            </button>

                            <a href="{{ route('trabajadores.index') }}"
                                class="text-gray-600 hover:text-gray-900">
                                Cancelar
                            </a>

                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow">
                                Volver
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>