<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Registrar Prestador a Honorarios

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 👤 HEADER DE NUEVO PRESTADOR --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    {{-- ================================================ --}}
                    {{-- 👤 INFORMACIÓN PRINCIPAL --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-5">

                        <div class="w-20 h-20 shrink-0 rounded-3xl bg-emerald-100 flex items-center justify-center text-4xl">

                            👤

                        </div>

                        <div>

                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">

                                Nuevo Prestador

                            </span>

                            <h1 class="mt-3 text-3xl font-bold text-gray-900">

                                Registrar Prestador a Honorarios

                            </h1>

                            <p class="mt-2 text-gray-500">

                                Ingresa los antecedentes del prestador y los datos de su primer contrato.

                            </p>

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 🔙 VOLVER A HONORARIOS --}}
                    {{-- ================================================ --}}

                    <div class="shrink-0">

                        <a
                            href="{{ route('admin.contratos-externos.honorarios.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 transition"
                        >

                            ← Volver a Honorarios

                        </a>

                    </div>

                </div>

            </div>

            
            {{-- ================================================= --}}
            {{-- 📝 FORMULARIO DE REGISTRO --}}
            {{-- ================================================= --}}

            <form
                method="POST"
                action="{{ route('admin.contratos-externos.honorarios.store') }}"
            >
                @csrf

                {{-- ================================================= --}}
                {{-- 👤 DATOS DEL PRESTADOR --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                    {{-- ================================================ --}}
                    {{-- 🪪 ENCABEZADO DE LA SECCIÓN --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">

                            🪪

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Datos del Prestador

                            </h2>

                            <p class="mt-1 text-gray-500">

                                Ingresa los antecedentes personales de quien prestará servicios a honorarios.

                            </p>

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 📝 DATOS PRINCIPALES --}}
                    {{-- ================================================ --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- NOMBRE --}}

                        <div>

                            <label
                                for="nombre"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre
                            </label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                placeholder="Ej: María"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                        {{-- APELLIDO --}}

                        <div>

                            <label
                                for="apellido"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Apellido
                            </label>

                            <input
                                type="text"
                                id="apellido"
                                name="apellido"
                                placeholder="Ej: González"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                        {{-- RUT --}}

                        <div>

                            <label
                                for="rut"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                RUT
                            </label>

                            <input
                                type="text"
                                id="rut"
                                name="rut"
                                placeholder="Ej: 12.345.678-5"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                        {{-- PROFESIÓN U OFICIO --}}

                        <div>

                            <label
                                for="profesion_oficio"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Profesión u Oficio
                            </label>

                            <input
                                type="text"
                                id="profesion_oficio"
                                name="profesion_oficio"
                                placeholder="Ej: Secretaria"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                        {{-- ================================================ --}}
                        {{-- 📍 CONTACTO Y UBICACIÓN --}}
                        {{-- ================================================ --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            {{-- DIRECCIÓN --}}

                            <div class="md:col-span-2">

                                <label
                                    for="direccion"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Dirección
                                </label>

                                <input
                                    type="text"
                                    id="direccion"
                                    name="direccion"
                                    placeholder="Ej: Av. Principal 123"
                                    class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                >

                            </div>

                            {{-- CORREO ELECTRÓNICO --}}

                            <div>

                                <label
                                    for="correo"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Correo Electrónico
                                </label>

                                <input
                                    type="email"
                                    id="correo"
                                    name="correo"
                                    placeholder="Ej: maria@email.com"
                                    class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                >

                            </div>

                            {{-- TELÉFONO --}}

                            <div>

                                <label
                                    for="telefono"
                                    class="block text-sm font-semibold text-gray-700 mb-2"
                                >
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    id="telefono"
                                    name="telefono"
                                    placeholder="Ej: 9 1234 5678"
                                    class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                >

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 📑 PRIMER CONTRATO --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                    {{-- ================================================ --}}
                    {{-- 📄 ENCABEZADO DE LA SECCIÓN --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">

                            📄

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Primer Contrato

                            </h2>

                            <p class="mt-1 text-gray-500">

                                Ingresa las condiciones principales del primer contrato a honorarios.

                            </p>

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 📝 DATOS DEL CONTRATO --}}
                    {{-- ================================================ --}}

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
                                placeholder="Ej: Secretaria de Reemplazo"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                        {{-- MONTO DE HONORARIOS --}}

                        <div>

                            <label
                                for="monto_honorarios"
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
                                placeholder="Ej: 650000"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                            <p class="mt-2 text-sm text-gray-500">
                                Ingresa el monto acordado.
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
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

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
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 🕒 JORNADA --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                    {{-- ================================================ --}}
                    {{-- 🕒 ENCABEZADO DE LA SECCIÓN --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">

                            🕒

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Jornada

                            </h2>

                            <p class="mt-1 text-gray-500">

                                Define el horario y la jornada semanal acordada para la prestación de servicios.

                            </p>

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- ⏰ HORARIO --}}
                    {{-- ================================================ --}}

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
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

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
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

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
                                placeholder="Ej: 40"
                                class="w-full rounded-2xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                            >

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
                            href="{{ route('admin.contratos-externos.honorarios.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-7 py-3 transition"
                        >
                            Cancelar
                        </a>


                        {{-- REGISTRAR PRESTADOR --}}
                        <button
                            type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-7 py-3 shadow-md transition"
                        >
                            💾 Registrar Prestador
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>