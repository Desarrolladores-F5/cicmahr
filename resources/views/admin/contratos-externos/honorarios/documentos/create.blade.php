<x-app-layout>

    {{-- ====================================================== --}}
    {{-- 📁 SUBIR DOCUMENTO DEL PRESTADOR --}}
    {{-- ====================================================== --}}

    <div class="py-10">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{-- 🔙 VOLVER AL EXPEDIENTE --}}
            {{-- ====================================================== --}}

            <div class="mb-6">

                <a
                    href="{{ route('admin.contratos-externos.honorarios.show', $honorario) }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition"
                >
                    ← Volver al expediente
                </a>

            </div>


            {{-- ====================================================== --}}
            {{-- 🧾 ENCABEZADO --}}
            {{-- ====================================================== --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden mb-8">

                <div class="p-8 sm:p-10">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                        <div class="flex items-center gap-5">

                            <div class="w-16 h-16 shrink-0 rounded-2xl bg-sky-100 flex items-center justify-center text-3xl">
                                📁
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">
                                    Expediente documental
                                </p>

                                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-gray-900">
                                    Subir Documento
                                </h1>

                                <p class="mt-2 text-sm text-gray-500">
                                    Agrega documentación personal o laboral al expediente del prestador.
                                </p>

                            </div>

                        </div>


                        {{-- PRESTADOR --}}
                        <div class="rounded-2xl bg-gray-50 border border-gray-100 px-5 py-4">

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Prestador
                            </p>

                            <p class="mt-1 font-bold text-gray-900">
                                {{ $honorario->nombre }} {{ $honorario->apellido }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                RUT {{ $honorario->rut }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- 📄 FORMULARIO --}}
            {{-- ====================================================== --}}

            <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 sm:p-10">

                {{-- IMPORTANTE:
                     Por ahora el formulario no tiene action.
                     Primero construiremos y probaremos la interfaz.
                --}}

                <form
                    method="POST"
                    action="{{ route('admin.contratos-externos.honorarios.documentos.store', $honorario) }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    {{-- ====================================================== --}}
                    {{-- 🏷️ TIPO DE DOCUMENTO --}}
                    {{-- ====================================================== --}}

                    <div>

                        <label
                            for="tipo"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Tipo de documento
                        </label>

                        <select
                            id="tipo"
                            name="tipo"
                            required
                            class="w-full rounded-2xl border-gray-300 focus:border-sky-500 focus:ring-sky-500"
                        >
                            <option value="">
                                Selecciona un tipo de documento
                            </option>

                            <option
                                value="Curriculum"
                                @selected(old('tipo') === 'Curriculum')
                            >
                                Curriculum
                            </option>

                            <option
                                value="Certificado de antecedentes"
                                @selected(old('tipo') === 'Certificado de antecedentes')
                            >
                                Certificado de antecedentes
                            </option>

                            <option
                                value="Cédula de identidad"
                                @selected(old('tipo') === 'Cédula de identidad')
                            >
                                Cédula de identidad
                            </option>

                            <option
                                value="Certificado de título"
                                @selected(old('tipo') === 'Certificado de título')
                            >
                                Certificado de título
                            </option>

                            <option
                                value="Otro"
                                @selected(old('tipo') === 'Otro')
                            >
                                Otro documento
                            </option>
                        </select>

                        @error('tipo')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs text-gray-400">
                            Selecciona la categoría que mejor represente el archivo.
                        </p>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 📎 ARCHIVO --}}
                    {{-- ====================================================== --}}

                    <div class="mt-8">

                        <label
                            for="archivo"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Archivo
                        </label>

                        <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 p-8">

                            <div class="text-center mb-6">

                                <div class="mx-auto w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl">
                                    📎
                                </div>

                                <h3 class="mt-4 font-semibold text-gray-800">
                                    Selecciona el documento
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    El archivo quedará asociado exclusivamente al expediente de este prestador.
                                </p>

                            </div>

                            <input
                                type="file"
                                id="archivo"
                                name="archivo"
                                required
                                class="block w-full text-sm text-gray-600
                                       file:mr-4
                                       file:rounded-xl
                                       file:border-0
                                       file:bg-sky-100
                                       file:px-4
                                       file:py-2.5
                                       file:text-sm
                                       file:font-semibold
                                       file:text-sky-700
                                       hover:file:bg-sky-200
                                       file:cursor-pointer"
                            >
                            @error('archivo')
                                <p class="mt-4 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="mt-4 text-xs text-gray-400">
                                Formatos permitidos: PDF, JPG, JPEG y PNG. Tamaño máximo: 10 MB.
                            </p>

                        </div>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 🔐 AVISO DE SEGURIDAD --}}
                    {{-- ====================================================== --}}

                    <div class="mt-8 rounded-2xl border border-sky-100 bg-sky-50 px-5 py-4">

                        <div class="flex items-start gap-3">

                            <div class="text-xl">
                                🔐
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-sky-900">
                                    Documento del expediente
                                </p>

                                <p class="mt-1 text-sm text-sky-700">
                                    Este archivo será almacenado como documentación interna
                                    asociada al prestador.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 🎛️ ACCIONES --}}
                    {{-- ====================================================== --}}

                    <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">

                        <a
                            href="{{ route('admin.contratos-externos.honorarios.show', $honorario) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-6 py-3 transition"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-3 shadow-sm transition"
                        >
                            📤 Guardar Documento
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>