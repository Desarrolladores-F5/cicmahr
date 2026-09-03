<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expediente del Prestador
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- ================================================= --}}
        {{-- 👤 CABECERA DEL EXPEDIENTE --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                {{-- INFORMACIÓN PRINCIPAL --}}
                <div class="flex items-center gap-5">

                    <div class="w-20 h-20 shrink-0 rounded-3xl bg-emerald-100 flex items-center justify-center text-4xl">
                        👤
                    </div>

                    <div>

                        <div class="flex flex-wrap items-center gap-3">

                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ $honorario->nombre }} {{ $honorario->apellido }}
                            </h1>

                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Activo
                            </span>

                        </div>

                        <p class="mt-2 text-lg font-medium text-gray-600">
                            {{ $honorario->profesion_oficio }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            RUT: {{ $honorario->rut }}
                        </p>

                    </div>

                </div>

                {{-- VOLVER --}}
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
        {{-- 🪪 DATOS DEL PRESTADOR --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

            {{-- ENCABEZADO --}}
            <div class="flex items-center gap-4 mb-8">

                <div class="w-14 h-14 shrink-0 rounded-2xl bg-indigo-100 flex items-center justify-center text-2xl">
                    🪪
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Datos del Prestador
                    </h2>

                    <p class="mt-1 text-gray-500">
                        Antecedentes personales y datos de contacto registrados en el expediente.
                    </p>
                </div>

            </div>

            {{-- INFORMACIÓN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

                {{-- RUT --}}
                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        RUT
                    </p>

                    <p class="mt-1 text-base font-medium text-gray-900">
                        {{ $honorario->rut }}
                    </p>
                </div>

                {{-- PROFESIÓN U OFICIO --}}
                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Profesión u Oficio
                    </p>

                    <p class="mt-1 text-base font-medium text-gray-900">
                        {{ $honorario->profesion_oficio }}
                    </p>
                </div>

                {{-- CORREO --}}
                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Correo Electrónico
                    </p>

                    <p class="mt-1 text-base font-medium text-gray-900">
                        {{ $honorario->correo }}
                    </p>
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <p class="text-sm font-semibold text-gray-500">
                        Teléfono
                    </p>

                    <p class="mt-1 text-base font-medium text-gray-900">
                        {{ $honorario->telefono }}
                    </p>
                </div>

                {{-- DIRECCIÓN --}}
                <div class="md:col-span-2">
                    <p class="text-sm font-semibold text-gray-500">
                        Dirección
                    </p>

                    <p class="mt-1 text-base font-medium text-gray-900">
                        {{ $honorario->direccion }}
                    </p>
                </div>

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- 📑 CONTRATO VIGENTE --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                        📑
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Contrato Vigente
                        </h2>

                        <p class="mt-1 text-gray-500">
                            Condiciones actuales de la prestación de servicios.
                        </p>
                    </div>

                </div>

                @if($contratoVigente)
                    <span class="inline-flex items-center gap-2 self-start sm:self-auto rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Vigente
                    </span>
                @endif

            </div>

            {{-- ================================================= --}}
            {{-- CONTRATO ENCONTRADO --}}
            {{-- ================================================= --}}

            @if($contratoVigente)

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-10 gap-y-7">

                    {{-- CARGO --}}
                    <div class="lg:col-span-2">
                        <p class="text-sm font-semibold text-gray-500">
                            Cargo
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            {{ $contratoVigente->cargo }}
                        </p>
                    </div>

                    {{-- MONTO DE HONORARIOS --}}
                    <div class="lg:col-span-2">
                        <p class="text-sm font-semibold text-gray-500">
                            Monto de Honorarios
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            ${{ number_format($contratoVigente->monto_honorario, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- FECHA DE INICIO --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Fecha de Inicio
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            {{ $contratoVigente->fecha_inicio->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- FECHA DE TÉRMINO --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Fecha de Término
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            {{ $contratoVigente->fecha_termino->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- HORARIO --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Horario
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            {{ substr($contratoVigente->hora_inicio, 0, 5) }}
                            -
                            {{ substr($contratoVigente->hora_termino, 0, 5) }}
                        </p>
                    </div>

                    {{-- HORAS SEMANALES --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Horas Semanales
                        </p>

                        <p class="mt-1 text-base font-medium text-gray-900">
                            {{ $contratoVigente->horas_semanales }} horas
                        </p>
                    </div>

                </div>

            @else

                {{-- ================================================= --}}
                {{-- SIN CONTRATO VIGENTE --}}
                {{-- ================================================= --}}

                <div class="rounded-2xl bg-gray-50 border border-gray-100 px-6 py-8 text-center">

                    <div class="text-3xl mb-3">
                        📭
                    </div>

                    <p class="font-semibold text-gray-700">
                        Este prestador no tiene un contrato vigente.
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Puedes revisar sus contratos anteriores en el historial del expediente.
                    </p>

                </div>

            @endif

        </div>

        {{-- ================================================= --}}
        {{-- 📚 HISTORIAL DE CONTRATOS --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mb-8">

            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                        📚
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Historial de Contratos
                        </h2>

                        <p class="mt-1 text-gray-500">
                            Revisa los contratos registrados anteriormente para este prestador.
                        </p>
                    </div>

                </div>

                {{-- ACCIONES --}}
                <div class="shrink-0 flex flex-wrap items-center gap-3">

                    {{-- CONTADOR --}}
                    <span class="inline-flex items-center rounded-full bg-violet-100 px-4 py-2 text-sm font-semibold text-violet-700">
                        {{ $honorario->contratos->count() }}
                        {{ $honorario->contratos->count() === 1 ? 'contrato' : 'contratos' }}
                    </span>

                    {{-- NUEVO CONTRATO --}}
                    <a
                        href="{{ route('admin.contratos-externos.honorarios.contratos.create', $honorario) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-violet-600 hover:bg-violet-700 text-white font-semibold px-5 py-2.5 shadow-sm transition"
                    >
                        ➕ Nuevo Contrato
                    </a>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- CONTRATOS REGISTRADOS --}}
            {{-- ================================================= --}}

            @if($honorario->contratos->isNotEmpty())

                <div class="space-y-4">

                    @foreach($honorario->contratos as $contrato)

                        <div class="rounded-2xl border border-gray-200 p-6">

                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                                {{-- INFORMACIÓN PRINCIPAL --}}
                                <div>

                                    <div class="flex flex-wrap items-center gap-3">

                                        <h3 class="text-lg font-bold text-gray-900">
                                            {{ $contrato->cargo }}
                                        </h3>

                                        @if($contrato->estado === 'vigente')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Vigente
                                            </span>

                                        @elseif($contrato->estado === 'proximo')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                Próximo
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                                Finalizado
                                            </span>

                                        @endif

                                    </div>

                                    <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">

                                        <span>
                                            📅
                                            {{ $contrato->fecha_inicio->format('d/m/Y') }}
                                            →
                                            {{ $contrato->fecha_termino->format('d/m/Y') }}
                                        </span>

                                        <span>
                                            🕒
                                            {{ substr($contrato->hora_inicio, 0, 5) }}
                                            -
                                            {{ substr($contrato->hora_termino, 0, 5) }}
                                        </span>

                                        <span>
                                            ⏱️ {{ $contrato->horas_semanales }} horas semanales
                                        </span>

                                    </div>

                                </div>

                                {{-- MONTO --}}
                                <div class="lg:text-right shrink-0">

                                    <p class="text-sm font-semibold text-gray-500">
                                        Honorarios
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-gray-900">
                                        ${{ number_format($contrato->monto_honorario, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>


                            {{-- CONTRATO FIRMADO --}}
                            <div class="mt-5 pt-5 border-t border-gray-100">

                                @if($contrato->ruta_archivo_contrato)

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                        <div class="flex items-start gap-3">

                                            <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-100 flex items-center justify-center">
                                                📄
                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-gray-900">
                                                    Contrato firmado
                                                </p>

                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ $contrato->nombre_archivo_contrato }}
                                                </p>

                                            </div>

                                        </div>

                                        <div class="flex flex-wrap items-center gap-2">

                                            <a
                                                href="{{ route('admin.contratos-externos.honorarios.contratos.archivo.ver', [
                                                    'honorario' => $honorario,
                                                    'contrato' => $contrato,
                                                ]) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold px-4 py-2 text-sm transition"
                                            >
                                                👁 Ver contrato
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.contratos-externos.honorarios.contratos.archivo.destroy', [
                                                    'honorario' => $honorario,
                                                    'contrato' => $contrato,
                                                ]) }}"
                                                onsubmit="return confirm('¿Estás seguro de eliminar el PDF del contrato firmado? El contrato y su historial permanecerán intactos.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2 text-sm transition"
                                                >
                                                    🗑 Eliminar PDF
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                @else

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                                        <div class="flex items-start gap-3">

                                            <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-100 flex items-center justify-center">
                                                📄
                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-gray-900">
                                                    Contrato firmado
                                                </p>

                                                <p class="mt-1 text-sm text-gray-500">
                                                    Aún no se ha adjuntado el contrato firmado.
                                                </p>

                                            </div>

                                        </div>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.contratos-externos.honorarios.contratos.archivo.store', [
                                                'honorario' => $honorario,
                                                'contrato' => $contrato,
                                            ]) }}"
                                            enctype="multipart/form-data"
                                            class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2"
                                        >
                                            @csrf

                                            <input
                                                type="file"
                                                name="archivo"
                                                accept=".pdf,application/pdf"
                                                required
                                                class="block w-full sm:w-auto text-sm text-gray-500
                                                    file:mr-3 file:rounded-xl file:border-0
                                                    file:bg-gray-100 file:px-4 file:py-2
                                                    file:text-sm file:font-semibold file:text-gray-700
                                                    hover:file:bg-gray-200"
                                            >

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 text-sm transition"
                                            >
                                                📤 Subir PDF
                                            </button>

                                        </form>

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- ================================================= --}}
                {{-- SIN HISTORIAL --}}
                {{-- ================================================= --}}

                <div class="rounded-2xl bg-gray-50 border border-gray-100 px-6 py-8 text-center">

                    <div class="text-3xl mb-3">
                        📭
                    </div>

                    <p class="font-semibold text-gray-700">
                        No existen contratos registrados.
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Los contratos del prestador aparecerán aquí.
                    </p>

                </div>

            @endif

        </div>

        {{-- ================================================= --}}
        {{-- 📁 DOCUMENTOS DEL PRESTADOR --}}
        {{-- ================================================= --}}

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 mt-8">

            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                        📁
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Documentos del Prestador
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Documentación personal y antecedentes asociados al expediente.
                        </p>
                    </div>

                </div>

                {{-- BOTÓN SUBIR DOCUMENTO --}}
                <a
                    href="{{ route('admin.contratos-externos.honorarios.documentos.create', $honorario) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-semibold px-5 py-2.5 shadow-sm transition"
                >
                    ➕ Subir Documento
                </a>

            </div>


            {{-- ================================================= --}}
            {{-- 📄 LISTADO DE DOCUMENTOS --}}
            {{-- ================================================= --}}

            @if($honorario->documentos->isEmpty())

                {{-- ESTADO VACÍO --}}
                <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">

                    <div class="mx-auto w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-3xl">
                        📄
                    </div>

                    <h3 class="mt-5 text-base font-semibold text-gray-800">
                        Aún no hay documentos registrados
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 max-w-lg mx-auto">
                        Aquí podrás almacenar curriculum, certificados de antecedentes,
                        identificación y otros documentos relacionados con el prestador.
                    </p>

                </div>

            @else

                <div class="space-y-4">

                    @foreach($honorario->documentos as $documento)

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 rounded-2xl border border-gray-200 p-5">

                            {{-- INFORMACIÓN --}}
                            <div class="flex items-start gap-4">

                                <div class="w-12 h-12 shrink-0 rounded-2xl bg-sky-50 flex items-center justify-center text-xl">
                                    📄
                                </div>

                                <div>

                                    <p class="font-semibold text-gray-900">
                                        {{ $documento->tipo }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $documento->nombre_original }}
                                    </p>

                                    <p class="mt-2 text-xs text-gray-400">
                                        Subido el {{ $documento->created_at->format('d/m/Y') }}
                                    </p>

                                </div>

                            </div>


                            {{-- ACCIONES --}}
                            <div class="flex items-center gap-3">

                                <a
                                    href="{{ route('admin.contratos-externos.honorarios.documentos.ver', [
                                        'honorario' => $honorario,
                                        'documento' => $documento,
                                    ]) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 text-sm transition"
                                >
                                    👁 Ver
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.contratos-externos.honorarios.documentos.destroy', [
                                        'honorario' => $honorario,
                                        'documento' => $documento,
                                    ]) }}"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este documento? Esta acción no se puede deshacer.');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2 text-sm transition"
                                    >
                                        🗑 Eliminar
                                    </button>
                                    
                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>
    </div>

</x-app-layout>