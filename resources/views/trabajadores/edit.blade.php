{{-- ====Este será tu FICHA DEL TRABAJADOR======= --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ficha del Trabajador
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

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
                ================================ --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 space-y-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">
                        Datos Personales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium">Nombre</label>
                            <input type="text" name="nombre"
                                value="{{ old('nombre', $trabajador->nombre) }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Apellido</label>
                            <input type="text" name="apellido"
                                value="{{ old('apellido', $trabajador->apellido) }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">RUT</label>
                        <input type="text"
                            value="{{ $trabajador->rut }}"
                            class="w-full border rounded-lg p-2 mt-1 bg-gray-100 cursor-not-allowed"
                            disabled>
                        <p class="text-xs text-gray-500 mt-1">
                            El RUT no puede modificarse.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Dirección</label>
                        <input type="text" name="direccion"
                            value="{{ old('direccion', $trabajador->direccion) }}"
                            class="w-full border rounded-lg p-2 mt-1">
                    </div>
                </div>

                {{-- ===============================
                    DATOS LABORALES
                ================================ --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 space-y-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">
                        Datos Laborales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">  
                        <div>
                            <label class="block text-sm font-medium">Cargo</label>
                            <input type="text" name="cargo"
                                value="{{ old('cargo', $trabajador->cargo) }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Sueldo</label>
                            <input type="number" step="0.01" name="sueldo"
                                value="{{ old('sueldo', $trabajador->sueldo ?? '') }}"
                                placeholder="Ej: 750000"
                                class="w-full border rounded-lg p-2 mt-1 placeholder-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium">Tipo de Contrato</label>
                            <select name="tipo_contrato" class="w-full border rounded-lg p-2 mt-1">
                                <option value="">Seleccione</option>
                                <option value="plazo_fijo"
                                    {{ $trabajador->tipo_contrato === 'plazo_fijo' ? 'selected' : '' }}>
                                    Plazo Fijo
                                </option>
                                <option value="indefinido"
                                    {{ $trabajador->tipo_contrato === 'indefinido' ? 'selected' : '' }}>
                                    Indefinido
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Estado</label>
                            <select name="estado" class="w-full border rounded-lg p-2 mt-1">
                                <option value="vigente"
                                    {{ $trabajador->estado === 'vigente' ? 'selected' : '' }}>
                                    Vigente
                                </option>
                                <option value="no_vigente"
                                    {{ $trabajador->estado === 'no_vigente' ? 'selected' : '' }}>
                                    No Vigente
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ===============================
                    FECHAS Y JORNADA
                ================================ --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 space-y-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">
                        Fechas y Jornada
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso"
                                value="{{ old('fecha_ingreso', $trabajador->fecha_ingreso) }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Fecha de Salida</label>
                            <input type="date" name="fecha_salida"
                                value="{{ old('fecha_salida', $trabajador->fecha_salida) }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Horario</label>
                        <input type="text" name="horario"
                            value="{{ old('horario', $trabajador->horario) }}"
                            class="w-full border rounded-lg p-2 mt-1">
                    </div>
                </div>

                

                {{-- BOTONES --}}
                <div class="flex gap-4 pt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Guardar Cambios
                    </button>

                    <a href="{{ route('trabajadores.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg shadow">
                        Volver
                    </a>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const tipoContrato = document.querySelector('select[name="tipo_contrato"]');
                    const fechaSalida = document.querySelector('input[name="fecha_salida"]');

                    function actualizarEstadoFechaSalida() {
                        if (tipoContrato.value === 'indefinido') {
                            fechaSalida.value = '';
                            fechaSalida.setAttribute('disabled', true);
                            fechaSalida.classList.add('bg-gray-100');
                        } else {
                            fechaSalida.removeAttribute('disabled');
                            fechaSalida.classList.remove('bg-gray-100');
                        }
                    }

                    actualizarEstadoFechaSalida(); // al cargar
                    tipoContrato.addEventListener('change', actualizarEstadoFechaSalida);

                });
                </script>

            </form>
            
            {{-- ============== DOCUMENTOS TRABAJADOR ==================--}}
            {{-- ============== DOCUMENTOS TRABAJADOR ==================--}}
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6 space-y-6 mb-8">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-700">Documentos</h3>
                    <span class="text-sm text-gray-500">PDF</span>
                </div>

                {{-- Success --}}
                @if(session('success'))
                    <div class="rounded-lg bg-green-50 p-3 text-green-800 border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="rounded-lg bg-red-50 p-3 text-red-800 border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM SUBIDA --}}
                <form method="POST"
                    action="{{ route('trabajadores.documentos.store', $trabajador) }}"
                    enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium">Tipo</label>
                            <select name="tipo_documento_id" class="w-full border rounded-lg p-2 mt-1">
                                <option value="">Seleccione</option>
                                @foreach($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->id }}" @selected(old('tipo_documento_id') == $tipo->id)>
                                        {{ $tipo->nombre_documento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Fecha documento</label>
                            <input type="date" name="fecha_documento"
                                value="{{ old('fecha_documento') }}"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">

                        <div>
                            <label class="block text-sm font-medium">PDF</label>
                            <input type="file" name="archivo" accept="application/pdf"
                                class="w-full border rounded-lg p-2 mt-1">
                        </div>

                        <div>
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                Subir Documento
                            </button>
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium">Observaciones</label>
                        <input type="text" name="observaciones"
                            value="{{ old('observaciones') }}"
                            placeholder="Ej: Contrato inicial, anexo, vacaciones..."
                            class="w-full border rounded-lg p-2 mt-1">
                    </div>

                </form>

                {{-- LISTA --}}
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Obs.</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($documentos as $doc)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $doc->tipoDocumento->nombre_documento ?? 'Sin tipo' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $doc->fecha_documento ? \Carbon\Carbon::parse($doc->fecha_documento)->format('d-m-Y') : '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $doc->observaciones ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-right space-x-4 whitespace-nowrap">

                                    {{-- VER --}}
                                    <a href="{{ asset('storage/' . $doc->ruta_archivo) }}"
                                       target="_blank"
                                       class="text-indigo-600 hover:underline">
                                        Ver
                                    </a>

                                    {{-- DESCARGAR --}}
                                    <a href="{{ route('trabajadores.documentos.download', [$trabajador, $doc]) }}"
                                        class="text-blue-600 hover:underline">
                                        Descargar
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <form method="POST"
                                        action="{{ route('trabajadores.documentos.destroy', [$trabajador, $doc]) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('¿Eliminar este documento?')"
                                                class="text-red-600 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    Aún no hay documentos subidos.
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