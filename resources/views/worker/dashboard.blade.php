<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Bienvenida --}}
        <div class="mb-8 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Bienvenido {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                </h1>

                <p class="text-gray-500 mt-2">
                    Gestiona tus documentos, solicitudes y actividades.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-4 min-w-[230px] text-center">

                <p class="text-xs text-gray-400 uppercase tracking-wider">
                    Último acceso
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    @if(auth()->user()->previous_login_at)
                        🕒 {{ auth()->user()->previous_login_at->format('d/m/Y H:i') }}
                    @else
                        Primer acceso
                    @endif
                </p>

            </div>

        </div>

        {{-- Titulo --}}
        <div class="mt-10 mb-4">
            <h2 class="text-xl font-bold text-gray-900">
                Información del Trabajador
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Datos principales asociados a tu relación laboral.
            </p>
        </div>

        {{-- Mensaje para cambiar contraseña temporal --}}
        @if(auth()->user()->must_change_password)
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-sm">

                <div>
                    <h3 class="font-bold text-amber-800">
                        ⚠️ Aún utilizas una contraseña temporal
                    </h3>

                    <p class="text-sm text-amber-700 mt-1">
                        Por seguridad, te recomendamos cambiarla por una contraseña personal.
                    </p>
                </div>

                <a href="{{ route('worker.password.edit') }}"
                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition">
                    Cambiar contraseña
                </a>

            </div>
        @endif


        {{-- Información del trabajador --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

            {{-- Empresa --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between mb-3">

                    <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-2xl">
                        🏢
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-sky-100 text-sky-700">
                        Empresa
                    </span>

                </div>

                <p class="text-lg font-bold text-gray-800">
                    {{ auth()->user()->empresa->nombre ?? 'Empresa' }}
                </p>

            </div>

            {{-- Cargo --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between mb-3">

                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">
                        💼
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700">
                        Cargo
                    </span>

                </div>

                <p class="text-lg font-bold text-gray-800">
                    {{ $trabajador->cargo ?? 'No registrado' }}
                </p>

            </div>

            {{-- Sueldo --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between mb-3">

                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl">
                        💰
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                        Sueldo
                    </span>

                </div>

                <p class="text-lg font-bold text-gray-800">
                    {{ $trabajador->sueldo
                        ? '$' . number_format($trabajador->sueldo, 0, ',', '.')
                        : 'No registrado' }}
                </p>

            </div>

            {{-- Horario --}}
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between mb-3">

                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-2xl">
                        🕒
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-700">
                        Horario
                    </span>

                </div>

                <p class="text-sm font-semibold text-gray-800">
                    {{ $trabajador->horario ?? 'No registrado' }}
                </p>

            </div>

        </div>

        {{-- Titulo --}}
        <div class="mb-4 mt-10">
            <h2 class="text-xl font-bold text-gray-900">
                Centro de Trabajo
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Accede rápidamente a tus módulos principales.
            </p>
        </div>

        {{-- Tarjetas rápidas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            {{-- Horas Extras --}}
            <a href="{{ route('worker.horas_extras') }}"
            class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">
                            Mis horas extras
                        </p>

                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($totalMesActual ?? 0, 1) }} hrs
                        </p>

                        <p class="text-sm text-gray-500 mt-2">
                            Ver detalle y monto estimado del mes
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                        ⏱
                    </div>
                </div>
            </a>

            {{-- Tarjeta vacaciones --}}
            <a href="{{ route('worker.vacaciones') }}" 
            class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Vacaciones</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Solicita tus vacaciones y revisa el estado de tus solicitudes.
                        </p>
                    </div>

                    <div class="text-3xl">
                        📅
                    </div>
                </div>
            </a>

            {{-- Reglamentos Internos--}}
            <a href="{{ route('worker.reglamentos.index') }}"
            class="relative block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                @if($pendientesReglamentos > 0)
                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full animate-pulse shadow-md">
                        {{ $pendientesReglamentos }}
                    </span>
                @endif

                <h3 class="text-lg font-semibold text-gray-800">
                    Reglamentos
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Consulta los reglamentos de la empresa.
                </p>

            </a>
            
            {{-- Mensajes--}}
            <a href="{{ route('worker.mensajes.index') }}"
            class="relative bg-white rounded-xl p-6 min-h-[130px] border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                @php
                    $mensajesNoLeidos = \App\Models\MensajeUser::where('user_id', auth()->id())
                        ->where('leido', false)
                        ->count();
                @endphp

                @if($mensajesNoLeidos > 0)

                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full animate-pulse shadow-md">
                        {{ $mensajesNoLeidos }}
                    </span>

                @endif

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="text-lg font-semibold text-gray-800">
                            Mensajes
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">

                            @if($mensajesNoLeidos > 0)

                                {{ $mensajesNoLeidos }} mensaje(s) pendiente(s)

                            @else

                                No tienes mensajes pendientes

                            @endif

                        </p>

                    </div>

                    <div class="text-3xl">
                        📨
                    </div>

                </div>

            </a>

            {{-- Mis Documentos--}}
            <a href="{{ route('worker.documentos') }}"
            class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="text-lg font-semibold text-gray-800">
                            Mis Documentos
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $totalDocumentos }} documento(s) disponible(s)
                        </p>

                    </div>

                    <div class="text-3xl">
                        📄
                    </div>

                </div>

            </a>
            
        </div>

        {{-- Últimos documentos --}}
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Últimos documentos
            </h2>

            @if($documentos->count())

                <table class="w-full">

                    <thead class="text-left text-gray-500 text-sm">
                        <tr>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach($documentos as $doc)

                            <tr>

                                <td class="py-3">
                                    {{ $doc->tipoDocumento->nombre_documento ?? 'Documento' }}
                                </td>

                                <td>
                                    {{ $doc->fecha_documento
                                        ? \Carbon\Carbon::parse($doc->fecha_documento)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td class="text-right">

                                    <a href="{{ route('worker.documentos.download', $doc) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                        Descargar
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="text-gray-500">
                    Aún no tienes documentos disponibles.
                </p>

            @endif

        </div>

    </div>

</x-app-layout>