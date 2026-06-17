{{-- ====Este será tu FICHA DEL TRABAJADOR======= --}}

<x-app-layout>
    
    <div class="max-w-8xl mx-auto px-6">

        <div class="mb-10">

            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                👤 Ficha del Trabajador
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Administra información personal, laboral y documentos asociados al trabajador.
            </p>

        </div>

    </div>

    <div class="py-10">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('trabajadores.update', $trabajador) }}">
                @csrf
                @method('PUT')

                {{-- ===============================
                DATOS PERSONALES
                =============================== --}}
                <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 space-y-8 mb-8">

                    {{-- Encabezado sección --}}
                    <div class="border-b border-gray-100 pb-5">

                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                                📇
                            </span>

                            Datos Personales
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Información básica y de contacto del trabajador.
                        </p>

                    </div>


                    {{-- Nombre y Apellido --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                value="{{ old('nombre', $trabajador->nombre) }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Apellido
                            </label>

                            <input
                                type="text"
                                name="apellido"
                                value="{{ old('apellido', $trabajador->apellido) }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>


                    {{-- RUT --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            RUT
                        </label>

                        <input
                            type="text"
                            value="{{ $trabajador->rut }}"
                            class="w-full rounded-2xl border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 cursor-not-allowed"
                            disabled
                        >

                        <p class="text-xs text-gray-500 mt-2">
                            El RUT no puede modificarse porque identifica legalmente al trabajador.
                        </p>
                    </div>


                    {{-- Dirección --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion"
                            value="{{ old('direccion', $trabajador->direccion) }}"
                            class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                </div>  

                {{-- ===============================
                    DATOS LABORALES
                ================================ --}}
                <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 space-y-8 mb-8">

                    {{-- Encabezado sección --}}
                    <div class="border-b border-gray-100 pb-5">

                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-xl">
                                💼
                            </span>

                            Datos Laborales
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Información contractual y administrativa del trabajador.
                        </p>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Cargo --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cargo
                            </label>

                            <input
                                type="text"
                                name="cargo"
                                value="{{ old('cargo', $trabajador->cargo) }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        {{-- Sueldo --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sueldo
                            </label>

                            <input
                                type="number"
                                step="1"
                                name="sueldo"
                                value="{{ old('sueldo', $trabajador->sueldo ? intval($trabajador->sueldo) : '') }}"
                                placeholder="Ej: 750000"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Tipo de Contrato --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo de Contrato
                            </label>

                            <select
                                name="tipo_contrato"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Seleccione</option>

                                <option value="plazo_fijo"
                                    {{ old('tipo_contrato', $trabajador->tipo_contrato) === 'plazo_fijo' ? 'selected' : '' }}>
                                    Plazo Fijo
                                </option>

                                <option value="indefinido"
                                    {{ old('tipo_contrato', $trabajador->tipo_contrato) === 'indefinido' ? 'selected' : '' }}>
                                    Indefinido
                                </option>
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Estado
                            </label>

                            <select
                                name="estado"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="vigente"
                                    {{ old('estado', $trabajador->estado) === 'vigente' ? 'selected' : '' }}>
                                    Vigente
                                </option>

                                <option value="no_vigente"
                                    {{ old('estado', $trabajador->estado) === 'no_vigente' ? 'selected' : '' }}>
                                    No Vigente
                                </option>
                            </select>
                        </div>

                    </div>

                </div>

                {{-- ===============================
                    FECHAS Y JORNADA
                ================================ --}}
                <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 space-y-8 mb-8">

                    {{-- Encabezado sección --}}
                    <div class="border-b border-gray-100 pb-5">

                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">

                            <span class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-xl">
                                📅
                            </span>

                            Fechas y Jornada

                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Información de ingreso, duración del contrato y jornada laboral.
                        </p>

                    </div>


                    {{-- Fechas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha de Ingreso
                            </label>

                            <input
                                type="date"
                                name="fecha_ingreso"
                                value="{{ old('fecha_ingreso', $trabajador->fecha_ingreso) }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha de Salida
                            </label>

                            <input
                                type="date"
                                name="fecha_salida"
                                value="{{ old('fecha_salida', $trabajador->fecha_salida) }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>


                    {{-- Horario --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Horario
                        </label>

                        <input
                            type="text"
                            name="horario"
                            value="{{ old('horario', $trabajador->horario) }}"
                            placeholder="Ej: Lunes a viernes de 09:00 a 18:00 horas"
                            class="w-full rounded-2xl border-gray-300 px-4 py-3 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                        >

                    </div>


                    {{-- Horas semanales --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Horas semanales
                        </label>

                        <input
                            type="number"
                            name="horas_semanales"
                            value="{{ old('horas_semanales', $trabajador->horas_semanales ?? 42) }}"
                            min="1"
                            max="42"
                            required
                            class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >

                        <p class="text-sm text-gray-500 mt-3">
                            ⏱️ Jornada semanal del trabajador. Máximo permitido: 42 horas.
                        </p>

                    </div>

                </div>                

                {{-- BOTONES --}}
                <div class="flex items-center gap-4 pt-6">

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 transition">

                        💾 Guardar Cambios

                    </button>

                    <a
                        href="{{ route('trabajadores.index') }}"
                        class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl bg-gray-100 text-gray-700 font-semibold shadow hover:bg-gray-200 transition">

                        ← Volver

                    </a>

                </div>            
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const tipoContrato = document.querySelector('select[name="tipo_contrato"]');
                    const fechaSalida = document.querySelector('input[name="fecha_salida"]');

                    function actualizarEstadoFechaSalida() {

                        if (tipoContrato.value === 'indefinido') {

                            fechaSalida.value = '';
                            fechaSalida.setAttribute('disabled', true);

                            fechaSalida.classList.add(
                                'bg-gray-100',
                                'cursor-not-allowed'
                            );

                        } else {

                            fechaSalida.removeAttribute('disabled');

                            fechaSalida.classList.remove(
                                'bg-gray-100',
                                'cursor-not-allowed'
                            );
                        }

                    }

                    actualizarEstadoFechaSalida(); // al cargar
                    tipoContrato.addEventListener('change', actualizarEstadoFechaSalida);

                });
            </script>

            {{-- ============== ACCESO AL PORTAL CON CORREO ==================--}}
            {{-- ============== ACCESO AL PORTAL CON CORREO  ==================--}}

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 mt-8">

                {{-- Encabezado --}}
                <div class="border-b border-gray-100 pb-5 mb-6">

                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">

                        <span class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-xl">
                            🔐
                        </span>

                        Acceso al Portal

                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Administra las credenciales y el correo asociado al trabajador.
                    </p>

                </div>

                @if(session('portal_success'))
                    <div class="rounded-lg bg-green-50 p-3 text-green-800 border border-green-200 mb-4">
                        {{ session('portal_success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-lg bg-red-50 p-3 text-red-800 border border-red-200 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('trabajadores.acceso', $trabajador) }}">
                    @csrf

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', optional($trabajador->user)->email) }}"
                            class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                    </div>

                    <div class="flex flex-wrap gap-4 mt-6">

                        <button
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 transition">

                            📧
                            {{ $trabajador->user_id ? 'Actualizar correo' : 'Crear acceso' }}

                        </button>

                    </div>
                </form>

                @if($trabajador->user_id)

                    <form method="POST" action="{{ route('trabajadores.resetPassword', $trabajador) }}" class="mt-3">
                    @csrf
                        
                        <p class="text-sm text-amber-600 mt-6 mb-4">

                            ⚠️ El trabajador recibirá una nueva contraseña temporal y podrá cambiarla posteriormente desde su portal.

                        </p>

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-orange-500 text-white font-semibold shadow-md hover:bg-orange-600 transition"
                            onclick="return confirm('¿Generar nueva contraseña temporal para este trabajador?')">

                            🔑 Generar nueva clave

                        </button>
                    </form>

                @endif

            </div>
            
            {{-- ============== DOCUMENTOS TRABAJADOR ==================--}}
            {{-- ============== DOCUMENTOS TRABAJADOR ==================--}}
            <div class="bg-white shadow-md border border-gray-100 rounded-3xl p-8 space-y-8 mb-8">

                {{-- Encabezado --}}
                <div class="border-b border-gray-100 pb-5">

                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                            📄
                        </span>

                        Documentos Laborales
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Sube y administra documentos asociados a la ficha del trabajador.
                    </p>

                </div>

                {{-- Success --}}
                @if(session('success'))
                    <div class="rounded-2xl bg-green-50 p-4 text-green-800 border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="rounded-2xl bg-red-50 p-4 text-red-800 border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM SUBIDA --}}
                <form
                    method="POST"
                    action="{{ route('trabajadores.documentos.store', $trabajador) }}"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Tipo y fecha --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo de documento
                            </label>

                            <select
                                name="tipo_documento_id"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Seleccione</option>

                                @foreach($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->id }}" @selected(old('tipo_documento_id') == $tipo->id)>
                                        {{ $tipo->nombre_documento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha documento
                            </label>

                            <input
                                type="date"
                                name="fecha_documento"
                                value="{{ old('fecha_documento') }}"
                                class="w-full rounded-2xl border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>

                    {{-- Observaciones --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            rows="3"
                            placeholder="Ej: Contrato inicial, anexo de sueldo, vacaciones, certificado médico..."
                            class="w-full rounded-2xl border-gray-300 px-4 py-3 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                        >{{ old('observaciones') }}</textarea>

                        <p class="mt-2 text-sm text-gray-500">
                            Agrega una breve descripción para identificar rápidamente el documento.
                        </p>
                    </div>

                    {{-- PDF y botón --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Archivo PDF
                            </label>

                            <input
                                type="file"
                                name="archivo"
                                accept="application/pdf"
                                class="w-full rounded-2xl border border-gray-300 px-4 py-3 bg-white focus:border-blue-500 focus:ring-blue-500"
                            >

                            <p class="mt-2 text-sm text-gray-500">
                                Solo se permiten documentos en formato PDF.
                            </p>
                        </div>

                        <div class="md:pt-8">
                            <button
                                type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 shadow-md transition"
                            >
                                ⬆️ Subir Documento
                            </button>
                        </div>

                    </div>

                </form>

                {{-- LISTA --}}
                <div class="overflow-hidden rounded-3xl border border-gray-100 shadow-sm">

                    <table class="min-w-full divide-y divide-gray-100">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Documento
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Fecha
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                    Observación
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @forelse($documentos as $doc)

                                <tr class="hover:bg-gray-50 transition">

                                    {{-- Documento --}}
                                    <td class="px-6 py-5">

                                        <div class="font-semibold text-gray-900">
                                            📄 {{ $doc->tipoDocumento->nombre_documento ?? 'Sin tipo' }}
                                        </div>

                                    </td>

                                    {{-- Fecha --}}
                                    <td class="px-6 py-5 text-gray-700">
                                        {{ $doc->fecha_documento ? \Carbon\Carbon::parse($doc->fecha_documento)->format('d-m-Y') : '-' }}
                                    </td>

                                    {{-- Observación --}}
                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $doc->observaciones ?? '-' }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-5 text-right whitespace-nowrap">

                                        <div class="inline-flex items-center gap-2">

                                            {{-- VER --}}
                                            <a
                                                href="{{ asset('storage/' . $doc->ruta_archivo) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-2 rounded-xl bg-indigo-50 text-indigo-700 text-sm font-semibold hover:bg-indigo-100 transition"
                                            >
                                                👁 Ver
                                            </a>

                                            {{-- DESCARGAR --}}
                                            <a
                                                href="{{ route('trabajadores.documentos.download', [$trabajador, $doc]) }}"
                                                class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition"
                                            >
                                                ⬇️ Descargar
                                            </a>

                                            {{-- ELIMINAR --}}
                                            <form
                                                method="POST"
                                                action="{{ route('trabajadores.documentos.destroy', [$trabajador, $doc]) }}"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('¿Eliminar este documento?')"
                                                    class="inline-flex items-center px-3 py-2 rounded-xl bg-red-50 text-red-700 text-sm font-semibold hover:bg-red-100 transition"
                                                >
                                                    🗑 Eliminar
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">

                                        <div class="text-4xl mb-3">
                                            📭
                                        </div>

                                        <p class="font-semibold text-gray-700">
                                            Aún no hay documentos subidos
                                        </p>

                                        <p class="text-sm text-gray-500 mt-1">
                                            Cuando subas documentos laborales aparecerán aquí.
                                        </p>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>