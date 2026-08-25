<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Editar Empresa Externa

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- ✏️ HEADER DE EDICIÓN --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                    {{-- ================================================ --}}
                    {{-- 🏢 INFORMACIÓN DE LA EMPRESA --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-5">

                        <div class="w-20 h-20 shrink-0 rounded-3xl bg-blue-100 flex items-center justify-center text-4xl">

                            🏢

                        </div>

                        <div>

                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                                Editando Empresa Externa

                            </span>

                            <h1 class="mt-3 text-3xl font-bold text-gray-900">

                                {{ $empresaExterna->nombre_fantasia ?: $empresaExterna->razon_social }}

                            </h1>

                            @if($empresaExterna->nombre_fantasia)

                                <p class="mt-2 text-gray-500">

                                    {{ $empresaExterna->razon_social }}

                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 🔙 VOLVER AL EXPEDIENTE --}}
                    {{-- ================================================ --}}

                    <div>

                        <a
                            href="{{ route('admin.contratos-externos.empresas.show', $empresaExterna) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 transition">

                            ← Volver al Expediente

                        </a>

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- ✏️ FORMULARIO DE EDICIÓN --}}
            {{-- ================================================= --}}

            <form
                action="{{ route('admin.contratos-externos.empresas.update', $empresaExterna) }}"
                method="POST"
                class="mt-8 space-y-8"
            >

                @csrf

                @method('PUT')


                {{-- ================================================= --}}
                {{-- 📋 INFORMACIÓN GENERAL --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">

                            📋

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Información General

                            </h2>

                            <p class="mt-1 text-sm text-gray-500">

                                Actualiza los datos principales de la empresa externa.

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 🏢 RAZÓN SOCIAL / NOMBRE FANTASÍA --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div>

                            <label
                                for="razon_social"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Razón Social
                            </label>

                            <input
                                type="text"
                                id="razon_social"
                                name="razon_social"
                                value="{{ old('razon_social', $empresaExterna->razon_social) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="nombre_fantasia"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre Fantasía
                            </label>

                            <input
                                type="text"
                                id="nombre_fantasia"
                                name="nombre_fantasia"
                                value="{{ old('nombre_fantasia', $empresaExterna->nombre_fantasia) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 🪪 RUT / ACTIVIDAD --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                        <div>

                            <label
                                for="rut_empresa"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                RUT Empresa
                            </label>

                            <input
                                type="text"
                                id="rut_empresa"
                                name="rut_empresa"
                                value="{{ old('rut_empresa', $empresaExterna->rut_empresa) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="actividad"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Actividad
                            </label>

                            <input
                                type="text"
                                id="actividad"
                                name="actividad"
                                value="{{ old('actividad', $empresaExterna->actividad) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 👤 REPRESENTANTE LEGAL --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">

                            👤

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Representante Legal

                            </h2>

                            <p class="mt-1 text-sm text-gray-500">

                                Actualiza los antecedentes de la persona que representa legalmente a la empresa.

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 👤 NOMBRE / RUT --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div>

                            <label
                                for="nombre_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre del Representante
                            </label>

                            <input
                                type="text"
                                id="nombre_representante"
                                name="nombre_representante"
                                value="{{ old('nombre_representante', $empresaExterna->nombre_representante) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="rut_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                RUT del Representante
                            </label>

                            <input
                                type="text"
                                id="rut_representante"
                                name="rut_representante"
                                value="{{ old('rut_representante', $empresaExterna->rut_representante) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 🎓 PROFESIÓN / ESTADO CIVIL --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                        <div>

                            <label
                                for="profesion_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Profesión
                            </label>

                            <input
                                type="text"
                                id="profesion_representante"
                                name="profesion_representante"
                                value="{{ old('profesion_representante', $empresaExterna->profesion_representante) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="estado_civil_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Estado Civil
                            </label>

                            <select
                                id="estado_civil_representante"
                                name="estado_civil_representante"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Selecciona una opción
                                </option>

                                <option
                                    value="soltero"
                                    @selected(old('estado_civil_representante', $empresaExterna->estado_civil_representante) === 'soltero')
                                >
                                    Soltero/a
                                </option>

                                <option
                                    value="casado"
                                    @selected(old('estado_civil_representante', $empresaExterna->estado_civil_representante) === 'casado')
                                >
                                    Casado/a
                                </option>

                                <option
                                    value="divorciado"
                                    @selected(old('estado_civil_representante', $empresaExterna->estado_civil_representante) === 'divorciado')
                                >
                                    Divorciado/a
                                </option>

                                <option
                                    value="viudo"
                                    @selected(old('estado_civil_representante', $empresaExterna->estado_civil_representante) === 'viudo')
                                >
                                    Viudo/a
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- 📞 CONTACTO Y UBICACIÓN --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">

                            📍

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Contacto y Ubicación

                            </h2>

                            <p class="mt-1 text-sm text-gray-500">

                                Actualiza los datos de contacto y ubicación de la empresa externa.

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- ✉️ CORREO EMPRESA / TELÉFONO EMPRESA --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div>

                            <label
                                for="correo_empresa"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Correo de la Empresa
                            </label>

                            <input
                                type="email"
                                id="correo_empresa"
                                name="correo_empresa"
                                value="{{ old('correo_empresa', $empresaExterna->correo_empresa) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="telefono_empresa"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Teléfono de la Empresa
                            </label>

                            <input
                                type="text"
                                id="telefono_empresa"
                                name="telefono_empresa"
                                value="{{ old('telefono_empresa', $empresaExterna->telefono_empresa) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 👤 CORREO REPRESENTANTE / TELÉFONO REPRESENTANTE --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                        <div>

                            <label
                                for="correo_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Correo del Representante
                            </label>

                            <input
                                type="email"
                                id="correo_representante"
                                name="correo_representante"
                                value="{{ old('correo_representante', $empresaExterna->correo_representante) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="telefono_representante"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Teléfono del Representante
                            </label>

                            <input
                                type="text"
                                id="telefono_representante"
                                name="telefono_representante"
                                value="{{ old('telefono_representante', $empresaExterna->telefono_representante) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- 🏠 DIRECCIÓN / CIUDAD --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                        <div>

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
                                value="{{ old('direccion', $empresaExterna->direccion) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="ciudad"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Ciudad
                            </label>

                            <input
                                type="text"
                                id="ciudad"
                                name="ciudad"
                                value="{{ old('ciudad', $empresaExterna->ciudad) }}"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>

                </div>

                {{-- ================================================= --}}
                {{-- ⚙️ ESTADO Y ACCIONES --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">

                        {{-- ================================================ --}}
                        {{-- 🟢 ESTADO DE LA EMPRESA --}}
                        {{-- ================================================ --}}

                        <div class="w-full lg:max-w-md">

                            <label
                                for="estado"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Estado de la Empresa
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option
                                    value="activo"
                                    @selected(old('estado', $empresaExterna->estado) === 'activo')
                                >
                                    🟢 Activo
                                </option>

                                <option
                                    value="inactivo"
                                    @selected(old('estado', $empresaExterna->estado) === 'inactivo')
                                >
                                    ⚪ Inactivo
                                </option>

                            </select>

                            <p class="mt-2 text-sm text-gray-500">

                                Define si la empresa externa se encuentra actualmente activa en el sistema.

                            </p>

                        </div>


                        {{-- ================================================ --}}
                        {{-- 💾 ACCIONES --}}
                        {{-- ================================================ --}}

                        <div class="flex flex-col sm:flex-row gap-3">

                            <a
                                href="{{ route('admin.contratos-externos.empresas.show', $empresaExterna) }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 transition"
                            >

                                Cancelar

                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-7 py-3 shadow-md transition"
                            >

                                💾 Guardar Cambios

                            </button>

                        </div>

                    </div>

                </div>


            </form>

        </div>

    </div>

</x-app-layout>