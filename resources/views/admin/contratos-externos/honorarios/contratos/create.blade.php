<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Contrato
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📑 CABECERA NUEVO CONTRATO --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    {{-- INFORMACIÓN DEL PRESTADOR --}}
                    <div class="flex items-center gap-5">

                        <div class="w-20 h-20 shrink-0 rounded-3xl bg-violet-100 flex items-center justify-center text-4xl">
                            📑
                        </div>

                        <div>

                            <span class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">
                                Nuevo Contrato
                            </span>

                            <h1 class="mt-3 text-3xl font-bold text-gray-900">
                                {{ $honorario->nombre }} {{ $honorario->apellido }}
                            </h1>

                            <div class="mt-2 flex flex-wrap items-center gap-x-5 gap-y-1 text-gray-500">

                                <span>
                                    RUT: {{ $honorario->rut }}
                                </span>

                                <span>
                                    {{ $honorario->profesion_oficio }}
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- VOLVER AL EXPEDIENTE --}}
                    <div class="shrink-0">

                        <a
                            href="{{ route('admin.contratos-externos.honorarios.show', $honorario) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 transition"
                        >
                            ← Volver al Expediente
                        </a>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- 📑 FORMULARIO NUEVO CONTRATO --}}
            {{-- ================================================= --}}

            <form
                method="POST"
                action="{{ route('admin.contratos-externos.honorarios.contratos.store', $honorario) }}"
            >
                @csrf

                {{-- ================================================= --}}
                {{-- 📑 DATOS DEL CONTRATO --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                    {{-- ENCABEZADO --}}
                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                Datos del Contrato
                            </h2>

                            <p class="mt-1 text-gray-500">
                                Ingresa las condiciones principales del nuevo contrato a honorarios.
                            </p>
                        </div>

                    </div>

                    {{-- CAMPOS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- CARGO --}}
                        <div>
                            <label
                                for="cargo"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Cargo
                            </label>

                            <input
                                type="text"
                                id="cargo"
                                name="cargo"
                                value="{{ old('cargo') }}"
                                required
                                placeholder="Ej: Soporte Técnico Temporal"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('cargo')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- MONTO DE HONORARIOS --}}
                        <div>
                            <label
                                for="monto_honorario"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Monto de Honorarios
                            </label>

                            <input
                                type="number"
                                id="monto_honorario"
                                name="monto_honorario"
                                min="0"
                                step="1"
                                value="{{ old('monto_honorario') }}"
                                required
                                placeholder="Ej: 650000"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('monto_honorario')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-2 text-sm text-gray-500">
                                Ingresa el monto acordado en pesos chilenos.
                            </p>
                        </div>

                        {{-- FECHA DE INICIO --}}
                        <div>
                            <label
                                for="fecha_inicio"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Fecha de Inicio
                            </label>

                            <input
                                type="date"
                                id="fecha_inicio"
                                name="fecha_inicio"
                                value="{{ old('fecha_inicio') }}"
                                required
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('fecha_inicio')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- FECHA DE TÉRMINO --}}
                        <div>
                            <label
                                for="fecha_termino"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Fecha de Término
                            </label>

                            <input
                                type="date"
                                id="fecha_termino"
                                name="fecha_termino"
                                value="{{ old('fecha_termino') }}"
                                required
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('fecha_termino')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 🕒 JORNADA --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                    {{-- ENCABEZADO --}}
                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                            🕒
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                Jornada
                            </h2>

                            <p class="mt-1 text-gray-500">
                                Define el horario y la jornada semanal acordada para este nuevo contrato.
                            </p>
                        </div>

                    </div>

                    {{-- CAMPOS --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- HORA DE INICIO --}}
                        <div>
                            <label
                                for="hora_inicio"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Hora de Inicio
                            </label>

                            <input
                                type="time"
                                id="hora_inicio"
                                name="hora_inicio"
                                value="{{ old('hora_inicio') }}"
                                required
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('hora_inicio')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- HORA DE TÉRMINO --}}
                        <div>
                            <label
                                for="hora_termino"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Hora de Término
                            </label>

                            <input
                                type="time"
                                id="hora_termino"
                                name="hora_termino"
                                value="{{ old('hora_termino') }}"
                                required
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('hora_termino')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror       
                        </div>

                        {{-- HORAS SEMANALES --}}
                        <div>
                            <label
                                for="horas_semanales"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Horas Semanales
                            </label>

                            <input
                                type="number"
                                id="horas_semanales"
                                name="horas_semanales"
                                min="1"
                                value="{{ old('horas_semanales') }}"
                                required
                                placeholder="Ej: 40"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('horas_semanales')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 💾 ACCIONES DEL FORMULARIO --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4">

                        {{-- CANCELAR --}}
                        <a
                            href="{{ route('admin.contratos-externos.honorarios.show', $honorario) }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-7 py-3 transition"
                        >
                            Cancelar
                        </a>

                        {{-- GUARDAR CONTRATO --}}
                        <button
                            type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl bg-violet-600 hover:bg-violet-700 text-white font-semibold px-7 py-3 shadow-md transition"
                        >
                            💾 Guardar Contrato
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>