<x-app-layout>

    <x-slot name="header">

        <div>

            {{-- Breadcrumb --}}
            <nav class="mb-4 flex flex-wrap items-center gap-2 text-sm text-gray-500">

                <a href="{{ route('admin.dashboard') }}"
                   class="transition hover:text-blue-600">
                    Dashboard
                </a>

                <span>/</span>

                <a href="{{ route('admin.contratos-externos.index') }}"
                   class="transition hover:text-blue-600">
                    Contratos Externos
                </a>

                <span>/</span>

                <a href="{{ route('admin.contratos-externos.empresas.index') }}"
                   class="transition hover:text-blue-600">
                    Empresas Externas
                </a>

                <span>/</span>

                <span class="font-semibold text-gray-700">
                    Registrar Empresa
                </span>

            </nav>

            {{-- Título --}}
            <div class="flex items-center gap-4">

                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-3xl shadow-sm">
                    🏢
                </div>

                <div>

                    <h2 class="text-3xl font-bold text-gray-900">
                        Registrar Empresa Externa
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Crea un expediente para administrar empresas proveedoras,
                        convenios comerciales y servicios externos asociados a tu organización.
                    </p>

                </div>

            </div>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📋 EXPEDIENTE EMPRESA EXTERNA --}}
            {{-- ================================================= --}}

            <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-md">

                {{-- Encabezado de la card --}}
                <div class="border-b border-gray-100 px-8 py-6">

                    <div class="flex items-center gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                            📋
                        </div>

                        <div>

                            <h3 class="text-2xl font-bold text-gray-900">
                                Datos del expediente
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Completa la información general de la empresa externa y de su representante legal.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Contenido del formulario --}}
                <div class="p-8">

                    <form method="POST"
                        action="{{ route('admin.contratos-externos.empresas.store') }}"
                        class="space-y-10">

                        @csrf

                        {{-- ================================================= --}}
                        {{-- 🏢 DATOS DE LA EMPRESA EXTERNA --}}
                        {{-- ================================================= --}}

                        <div>

                            <div class="mb-8">

                                <h3 class="text-xl font-bold text-gray-900">
                                    🏢 Datos de la Empresa
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Información general de la empresa proveedora.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Razón Social --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Razón Social *
                                    </label>

                                    <input
                                        type="text"
                                        name="razon_social"
                                        value="{{ old('razon_social') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                </div>

                                {{-- RUT --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        RUT Empresa *
                                    </label>

                                    <input
                                        type="text"
                                        name="rut_empresa"
                                        value="{{ old('rut_empresa') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                </div>

                                {{-- Nombre Fantasía --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre Fantasía
                                    </label>

                                    <input
                                        type="text"
                                        name="nombre_fantasia"
                                        value="{{ old('nombre_fantasia') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                </div>

                                {{-- Actividad --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Actividad *
                                    </label>

                                    <input
                                        type="text"
                                        name="actividad"
                                        value="{{ old('actividad') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                </div>

                            </div>

                        </div>

                        {{-- ================================================= --}}
                        {{-- 👤 REPRESENTANTE LEGAL --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-gray-100 pt-10">

                            <div class="mb-8">

                                <h3 class="text-xl font-bold text-gray-900">
                                    👤 Representante Legal
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Información de la persona que representa legalmente a la empresa.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Nombre --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nombre Completo *
                                    </label>

                                    <input
                                        type="text"
                                        name="nombre_representante"
                                        value="{{ old('nombre_representante') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('nombre_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- RUT --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        RUT *
                                    </label>

                                    <input
                                        type="text"
                                        name="rut_representante"
                                        value="{{ old('rut_representante') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('rut_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Profesión --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Profesión
                                    </label>

                                    <input
                                        type="text"
                                        name="profesion_representante"
                                        value="{{ old('profesion_representante') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('profesion_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Estado Civil --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Estado Civil
                                    </label>

                                    <select
                                        name="estado_civil_representante"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                        <option value="">Seleccione...</option>

                                        <option value="soltero" {{ old('estado_civil_representante') == 'soltero' ? 'selected' : '' }}>
                                            Soltero
                                        </option>

                                        <option value="casado" {{ old('estado_civil_representante') == 'casado' ? 'selected' : '' }}>
                                            Casado
                                        </option>

                                        <option value="divorciado" {{ old('estado_civil_representante') == 'divorciado' ? 'selected' : '' }}>
                                            Divorciado
                                        </option>

                                        <option value="viudo" {{ old('estado_civil_representante') == 'viudo' ? 'selected' : '' }}>
                                            Viudo
                                        </option>

                                        <option value="conviviente_civil" {{ old('estado_civil_representante') == 'conviviente_civil' ? 'selected' : '' }}>
                                            Conviviente Civil
                                        </option>

                                        <option value="separado" {{ old('estado_civil_representante') == 'separado' ? 'selected' : '' }}>
                                            Separado
                                        </option>

                                    </select>

                                    @error('estado_civil_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        {{-- ================================================= --}}
                        {{-- 📍 CONTACTO --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-gray-100 pt-10">

                            <div class="mb-8">

                                <h3 class="text-xl font-bold text-gray-900">
                                    📍 Información de Contacto
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Datos de contacto de la empresa y de su representante legal.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Correo Empresa --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Empresa
                                    </label>

                                    <input
                                        type="email"
                                        name="correo_empresa"
                                        value="{{ old('correo_empresa') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('correo_empresa')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Teléfono Empresa --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Empresa
                                    </label>

                                    <input
                                        type="text"
                                        name="telefono_empresa"
                                        value="{{ old('telefono_empresa') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('telefono_empresa')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Correo Representante --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Representante
                                    </label>

                                    <input
                                        type="email"
                                        name="correo_representante"
                                        value="{{ old('correo_representante') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('correo_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Teléfono Representante --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Representante
                                    </label>

                                    <input
                                        type="text"
                                        name="telefono_representante"
                                        value="{{ old('telefono_representante') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('telefono_representante')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Dirección --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Dirección
                                    </label>

                                    <input
                                        type="text"
                                        name="direccion"
                                        value="{{ old('direccion') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('direccion')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                                {{-- Ciudad --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Ciudad
                                    </label>

                                    <input
                                        type="text"
                                        name="ciudad"
                                        value="{{ old('ciudad') }}"
                                        class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                                    @error('ciudad')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        {{-- ================================================= --}}
                        {{-- ⚙️ ESTADO DEL EXPEDIENTE --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-gray-100 pt-10">

                            <div class="rounded-2xl border border-green-200 bg-green-50 p-6">

                                <div class="flex items-start gap-4">

                                    <div class="text-3xl">
                                        ✅
                                    </div>

                                    <div>

                                        <h3 class="text-lg font-bold text-green-800">
                                            Estado inicial del expediente
                                        </h3>

                                        <p class="mt-2 text-sm text-green-700">

                                            Toda empresa externa se registra inicialmente en estado
                                            <strong>Activo</strong>.

                                            Este estado podrá modificarse posteriormente desde la
                                            ficha de la empresa.

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <input type="hidden" name="estado" value="activo">

                        {{-- ================================================= --}}
                        {{-- 💾 ACCIONES --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-gray-200 pt-8">

                            <div class="flex flex-col-reverse gap-4 sm:flex-row sm:justify-end">

                                <a href="{{ route('admin.contratos-externos.empresas.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">

                                    ← Cancelar

                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                                    💾 Registrar Empresa

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>