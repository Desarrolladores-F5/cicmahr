<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expediente Empresa Externa
        </h2>

    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-6">

            {{-- ================================================= --}}
            {{-- 📁 HEADER PREMIUM DEL EXPEDIENTE --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                    {{-- ================================================ --}}
                    {{-- 🏢 INFORMACIÓN PRINCIPAL --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-6">

                        <div class="w-20 h-20 rounded-3xl bg-blue-100 flex items-center justify-center text-5xl">

                            🏢

                        </div>

                        <div>

                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                                Proveedor Externo

                            </span>
                            
                            <h1 class="mt-3 text-4xl font-bold text-gray-900">

                                {{ $empresaExterna->nombre_fantasia ?: $empresaExterna->razon_social }}

                            </h1>

                            @if($empresaExterna->nombre_fantasia)

                                <p class="mt-2 text-gray-500 text-lg">

                                    {{ $empresaExterna->razon_social }}

                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 🟢 ESTADO --}}
                    {{-- ================================================ --}}

                    <div class="flex flex-col items-start lg:items-end gap-4">

                        <span class="inline-flex items-center rounded-full bg-green-100 px-5 py-2 text-sm font-bold text-green-700">

                            🟢 {{ ucfirst($empresaExterna->estado) }}

                        </span>

                        <div class="flex flex-wrap gap-3">

                            <a
                                href="{{ route('admin.contratos-externos.empresas.edit', $empresaExterna) }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 transition">

                                ✏️ Editar

                            </a>

                            <a href="{{ route('admin.contratos-externos.empresas.documentos.index', $empresaExterna) }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold px-5 py-3 transition">

                                📄 Documentos

                            </a>

                            <a href="{{ route('admin.contratos-externos.empresas.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 font-semibold px-5 py-3 transition">

                                ← Volver

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 📋 INFORMACIÓN GENERAL --}}
            {{-- ================================================= --}}

            <div class="mt-8 bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                {{-- ================================================ --}}
                {{-- 📋 TÍTULO --}}
                {{-- ================================================ --}}

                <div class="flex items-center gap-3 mb-8">

                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">

                        📋

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">

                            Información General

                        </h2>

                        <p class="text-sm text-gray-500">

                            Datos principales de la empresa externa.

                        </p>

                    </div>

                </div>

                {{-- ================================================ --}}
                {{-- 📊 DATOS --}}
                {{-- ================================================ --}}

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

                    {{-- Razón Social --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Razón Social

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->razon_social }}

                        </p>

                    </div>

                    {{-- Nombre Fantasía --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Nombre Fantasía

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->nombre_fantasia ?: 'No informado' }}

                        </p>

                    </div>

                    {{-- RUT --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            RUT

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->rut_empresa }}

                        </p>

                    </div>

                    {{-- Actividad --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Actividad

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->actividad }}

                        </p>

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 👤 REPRESENTANTE LEGAL --}}
            {{-- ================================================= --}}

            <div class="mt-8 bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                {{-- ================================================ --}}
                {{-- 👤 TÍTULO --}}
                {{-- ================================================ --}}

                <div class="flex items-center gap-3 mb-8">

                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">

                        👤

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">

                            Representante Legal

                        </h2>

                        <p class="text-sm text-gray-500">

                            Persona responsable de representar legalmente a la empresa.

                        </p>

                    </div>

                </div>

                {{-- ================================================ --}}
                {{-- 📊 DATOS --}}
                {{-- ================================================ --}}

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

                    {{-- Nombre --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Nombre

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->nombre_representante }}

                        </p>

                    </div>

                    {{-- RUT --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            RUT

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->rut_representante }}

                        </p>

                    </div>

                    {{-- Profesión --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Profesión

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->profesion_representante ?: 'No informado' }}

                        </p>

                    </div>

                    {{-- Estado Civil --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Estado Civil

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ ucfirst($empresaExterna->estado_civil_representante ?: 'No informado') }}

                        </p>

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 📞 CONTACTO --}}
            {{-- ================================================= --}}

            <div class="mt-8 bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                {{-- ================================================ --}}
                {{-- 📞 TÍTULO --}}
                {{-- ================================================ --}}

                <div class="flex items-center gap-3 mb-8">

                    <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">

                        📞

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-gray-900">

                            Información de Contacto

                        </h2>

                        <p class="text-sm text-gray-500">

                            Medios de contacto de la empresa y su representante legal.

                        </p>

                    </div>

                </div>

                {{-- ================================================ --}}
                {{-- 📊 DATOS --}}
                {{-- ================================================ --}}

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                    {{-- Correo Empresa --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Correo Empresa

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->correo_empresa ?: 'No informado' }}

                        </p>

                    </div>

                    {{-- Teléfono Empresa --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Teléfono Empresa

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->telefono_empresa ?: 'No informado' }}

                        </p>

                    </div>

                    {{-- Dirección --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Dirección

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->direccion ?: 'No informada' }}

                        </p>

                    </div>

                    {{-- Ciudad --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Ciudad

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->ciudad ?: 'No informada' }}

                        </p>

                    </div>

                    {{-- Correo Representante --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Correo Representante

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->correo_representante ?: 'No informado' }}

                        </p>

                    </div>

                    {{-- Teléfono Representante --}}
                    <div>

                        <p class="text-xs uppercase tracking-wide text-gray-400">

                            Teléfono Representante

                        </p>

                        <p class="mt-2 text-lg font-semibold text-gray-900">

                            {{ $empresaExterna->telefono_representante ?: 'No informado' }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>