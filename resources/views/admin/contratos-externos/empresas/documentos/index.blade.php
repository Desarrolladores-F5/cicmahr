<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Documentación de Empresa Externa

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📄 HEADER DE DOCUMENTACIÓN --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    {{-- ================================================ --}}
                    {{-- 🏢 INFORMACIÓN DE LA EMPRESA --}}
                    {{-- ================================================ --}}

                    <div>

                        <div class="flex items-center gap-3 mb-3">

                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">

                                📄

                            </div>

                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">

                                Expediente Documental

                            </span>

                        </div>

                        <h1 class="text-3xl font-bold text-gray-900">

                            {{ $empresaExterna->nombre_fantasia ?: $empresaExterna->razon_social }}

                        </h1>

                        @if($empresaExterna->nombre_fantasia)

                            <p class="mt-2 text-gray-500">

                                {{ $empresaExterna->razon_social }}

                            </p>

                        @endif

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
            {{-- 📊 RESUMEN DOCUMENTAL --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6 mb-8">

                <div class="flex items-center justify-between gap-6">

                    <div>

                        <p class="text-sm font-medium text-gray-500">

                            Documentos registrados

                        </p>

                        <p class="mt-1 text-3xl font-bold text-indigo-700">

                            {{ $documentos->count() }}

                        </p>

                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

                        📁

                    </div>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- 📄 CONTENIDO DOCUMENTAL --}}
            {{-- ================================================= --}}

            @if($documentos->isEmpty())

                {{-- ================================================= --}}
                {{-- 📭 EMPTY STATE --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-16 text-center">

                    <div class="w-24 h-24 mx-auto rounded-3xl bg-indigo-50 flex items-center justify-center text-5xl">

                        📄

                    </div>

                    <h2 class="mt-7 text-3xl font-bold text-gray-900">

                        Aún no existen documentos

                    </h2>

                    <p class="mt-4 max-w-2xl mx-auto text-gray-500 leading-relaxed">

                        Incorpora la documentación legal, administrativa y contractual
                        asociada a esta empresa externa para mantener su expediente
                        organizado y actualizado.

                    </p>

                    <div class="mt-10">

                        <a
                            href="{{ route('admin.contratos-externos.empresas.documentos.create', $empresaExterna) }}"
                            class="inline-flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg transition">

                            ➕

                            Subir Primer Documento

                        </a>

                    </div>

                </div>

            @else

                {{-- ================================================= --}}
                {{-- 📚 LISTADO PREMIUM DE DOCUMENTOS --}}
                {{-- ================================================= --}}

                <div>

                    {{-- ================================================ --}}
                    {{-- ➕ ACCIONES DEL EXPEDIENTE DOCUMENTAL --}}
                    {{-- ================================================ --}}

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">

                                Documentos del Expediente

                            </h2>

                            <p class="mt-1 text-sm text-gray-500">

                                Documentación asociada a esta empresa externa.

                            </p>

                        </div>

                        <a
                            href="{{ route('admin.contratos-externos.empresas.documentos.create', $empresaExterna) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 shadow-md transition">

                            ➕

                            Subir Documento

                        </a>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 📄 DOCUMENTOS --}}
                    {{-- ================================================ --}}

                    <div class="grid gap-5">

                        @foreach($documentos as $documento)

                            @php

                                $tipoDocumento = match($documento->tipo_documento) {

                                    'legal' => [
                                        'label' => 'Legal',
                                        'icono' => '⚖️',
                                        'clases' => 'bg-blue-100 text-blue-700',
                                    ],

                                    'tributario' => [
                                        'label' => 'Tributario',
                                        'icono' => '💰',
                                        'clases' => 'bg-amber-100 text-amber-700',
                                    ],

                                    'laboral' => [
                                        'label' => 'Laboral',
                                        'icono' => '👷',
                                        'clases' => 'bg-green-100 text-green-700',
                                    ],

                                    'certificado' => [
                                        'label' => 'Certificado',
                                        'icono' => '📜',
                                        'clases' => 'bg-purple-100 text-purple-700',
                                    ],

                                    'antecedente' => [
                                        'label' => 'Antecedente',
                                        'icono' => '📋',
                                        'clases' => 'bg-cyan-100 text-cyan-700',
                                    ],

                                    default => [
                                        'label' => 'Otro',
                                        'icono' => '📄',
                                        'clases' => 'bg-gray-100 text-gray-700',
                                    ],

                                };

                            @endphp

                            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-6">

                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                                    {{-- ================================================ --}}
                                    {{-- 📄 INFORMACIÓN DEL DOCUMENTO --}}
                                    {{-- ================================================ --}}

                                    <div class="flex items-start gap-5">

                                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl">

                                            📄

                                        </div>

                                        <div>

                                            <div class="flex flex-wrap items-center gap-3">

                                                <h3 class="text-xl font-bold text-gray-900">

                                                    {{ $documento->nombre_documento }}

                                                </h3>

                                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $tipoDocumento['clases'] }}">

                                                    {{ $tipoDocumento['icono'] }}

                                                    {{ $tipoDocumento['label'] }}

                                                </span>

                                            </div>

                                            <p class="mt-2 text-sm text-gray-500">

                                                Incorporado el
                                                {{ $documento->created_at->format('d/m/Y') }}

                                            </p>

                                            @if($documento->observaciones)

                                                <p class="mt-3 text-sm text-gray-600 leading-relaxed">

                                                    {{ $documento->observaciones }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                    {{-- ================================================ --}}
                                    {{-- 🚀 ACCIONES --}}
                                    {{-- ================================================ --}}

                                    <div class="flex flex-wrap gap-3 lg:shrink-0">
                                            
                                        {{-- ================================================= --}}
                                        {{-- VER DOCUMENTO --}}
                                        {{-- ================================================= --}}
                                        <a
                                            href="{{ route(
                                                'admin.contratos-externos.empresas.documentos.show',
                                                [
                                                    'empresaExterna' => $empresaExterna,
                                                    'documento' => $documento
                                                ]
                                            ) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold px-5 py-3 transition">

                                            👁 Ver

                                        </a>
                                        
                                        {{-- ================================================= --}}
                                        {{-- DESCARGAR DOCUMENTO --}}
                                        {{-- ================================================= --}}
                                        <a
                                            href="{{ route(
                                                'admin.contratos-externos.empresas.documentos.download',
                                                [
                                                    'empresaExterna' => $empresaExterna,
                                                    'documento' => $documento
                                                ]
                                            ) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold px-5 py-3 transition">

                                            ⬇ Descargar

                                        </a>

                                        {{-- ================================================= --}}
                                        {{-- 🗑️ ELIMINAR DOCUMENTO --}}
                                        {{-- ================================================= --}}

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.contratos-externos.empresas.documentos.destroy',
                                                [
                                                    'empresaExterna' => $empresaExterna,
                                                    'documento' => $documento
                                                ]
                                            ) }}"
                                            onsubmit="return confirm('¿Está seguro que quiere eliminar este documento?')"
                                            class="inline-flex"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-5 py-3 transition"
                                            >
                                                🗑️ Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>