<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Subir Documento

        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- 📄 HEADER PREMIUM --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                    {{-- ================================================ --}}
                    {{-- 🏢 INFORMACIÓN DE LA EMPRESA --}}
                    {{-- ================================================ --}}

                    <div class="flex items-center gap-5">

                        <div class="w-20 h-20 rounded-3xl bg-indigo-100 flex items-center justify-center text-4xl shrink-0">

                            📄

                        </div>

                        <div>

                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">

                                Nuevo Documento

                            </span>

                            <h1 class="mt-3 text-3xl font-bold text-gray-900">

                                {{ $empresaExterna->nombre_fantasia ?: $empresaExterna->razon_social }}

                            </h1>

                            @if($empresaExterna->nombre_fantasia)

                                <p class="mt-1 text-gray-500">

                                    {{ $empresaExterna->razon_social }}

                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- ================================================ --}}
                    {{-- 🔙 VOLVER A DOCUMENTOS --}}
                    {{-- ================================================ --}}

                    <div>

                        <a
                            href="{{ route('admin.contratos-externos.empresas.documentos.index', $empresaExterna) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 transition">

                            ← Volver a Documentos

                        </a>

                    </div>

                </div>

            </div>

            {{-- ====================================================== --}}
            {{-- 📋 INFORMACIÓN DEL DOCUMENTO --}}
            {{-- ====================================================== --}}

            <form
                action="{{ route('admin.contratos-externos.empresas.documentos.store', $empresaExterna) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mt-8 bg-white rounded-3xl shadow-md border border-gray-100 p-8">

                    {{-- ENCABEZADO --}}
                    <div class="flex items-center gap-4 mb-8">

                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">
                                Información del Documento
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Ingresa los antecedentes del documento que será incorporado
                                al expediente de la empresa externa.
                            </p>

                        </div>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 📝 CAMPOS DEL DOCUMENTO --}}
                    {{-- ====================================================== --}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- NOMBRE DEL DOCUMENTO --}}
                        <div>

                            <label
                                for="nombre_documento"
                                class="block mb-2 text-sm font-semibold text-gray-700"
                            >
                                Nombre del Documento
                            </label>

                            <input
                                type="text"
                                id="nombre_documento"
                                name="nombre_documento"
                                placeholder="Ej: Escritura de Constitución"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                            <p class="mt-2 text-xs text-gray-400">
                                Nombre que permitirá identificar fácilmente el documento.
                            </p>

                        </div>


                        {{-- TIPO DE DOCUMENTO --}}
                        <div>

                            <label
                                for="tipo_documento"
                                class="block mb-2 text-sm font-semibold text-gray-700"
                            >
                                Tipo de Documento
                            </label>

                            <select
                                id="tipo_documento"
                                name="tipo_documento"
                                class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Selecciona un tipo
                                </option>

                                <option value="legal">
                                    Documento Legal
                                </option>

                                <option value="tributario">
                                    Documento Tributario
                                </option>

                                <option value="laboral">
                                    Documento Laboral
                                </option>

                                <option value="certificado">
                                    Certificado
                                </option>

                                <option value="antecedente">
                                    Antecedente Administrativo
                                </option>

                                <option value="otro">
                                    Otro Documento
                                </option>

                            </select>

                            <p class="mt-2 text-xs text-gray-400">
                                Clasifica el documento para mantener organizado el expediente.
                            </p>

                        </div>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 📎 ARCHIVO --}}
                    {{-- ====================================================== --}}

                    <div class="mt-8">

                        <label
                            for="archivo"
                            class="block mb-2 text-sm font-semibold text-gray-700"
                        >
                            Archivo
                        </label>

                        <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center">

                            <div class="text-4xl mb-3">
                                📎
                            </div>

                            <p class="font-semibold text-gray-700">
                                Selecciona el documento que deseas incorporar
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                PDF, JPG, JPEG o PNG
                            </p>

                            <input
                                type="file"
                                id="archivo"
                                name="archivo"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="mt-5 block w-full text-sm text-gray-500
                                    file:mr-4 file:rounded-xl file:border-0
                                    file:bg-blue-600 file:px-5 file:py-3
                                    file:font-semibold file:text-white
                                    hover:file:bg-blue-700"
                            >

                        </div>

                    </div>

                    {{-- ====================================================== --}}
                    {{-- 📝 OBSERVACIONES --}}
                    {{-- ====================================================== --}}

                    <div class="mt-8">

                        <label
                            for="observaciones"
                            class="block mb-2 text-sm font-semibold text-gray-700"
                        >
                            Observaciones
                        </label>

                        <textarea
                            id="observaciones"
                            name="observaciones"
                            rows="4"
                            placeholder="Agrega alguna información adicional sobre el documento..."
                            class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>

                        <p class="mt-2 text-xs text-gray-400">
                            Campo opcional para antecedentes o comentarios relacionados con el documento.
                        </p>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 💾 ACCIONES --}}
                    {{-- ====================================================== --}}

                    <div class="mt-8 pt-8 border-t border-gray-200">

                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                            <a
                                href="{{ route('admin.contratos-externos.empresas.documentos.index', $empresaExterna) }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 font-semibold px-6 py-3 transition"
                            >
                                ← Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-7 py-3 shadow-md transition"
                            >
                                💾 Guardar Documento
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>