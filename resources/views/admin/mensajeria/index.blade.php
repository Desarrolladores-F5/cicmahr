<x-app-layout>

    <div class="p-8">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Mensajería Interna ✉️
                </h1>

                <p class="mt-2 text-gray-500">
                    Comunícate con tus trabajadores de forma rápida y segura.
                </p>
            </div>

            <a href="{{ route('admin.mensajes.create') }}"
               class="px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                + Nuevo mensaje
            </a>

        </div>


        {{-- Mensaje éxito --}}
        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Card historial --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Header card --}}
            <div class="px-8 py-6 border-b border-gray-100">

                <h2 class="text-xl font-bold text-gray-800">
                    Historial de mensajes enviados
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Revisa las comunicaciones enviadas a los trabajadores.
                </p>

            </div>


            @if($mensajes->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Fecha
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Asunto
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Destinatario
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Tipo
                                </th>

                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                    Destinatarios
                                </th>

                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                                    Acción
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach($mensajes as $mensaje)

                                <tr class="hover:bg-gray-50 transition">

                                    {{-- Fecha --}}
                                    <td class="px-6 py-5 text-gray-600">
                                        {{ $mensaje->created_at->format('d/m/Y') }}
                                    </td>

                                    {{-- Asunto --}}
                                    <td class="px-6 py-5">

                                        <div class="font-semibold text-gray-800">
                                            {{ $mensaje->titulo }}
                                        </div>

                                    </td>

                                    {{-- Destinatario --}}
                                    <td class="px-6 py-5 text-gray-600">

                                        @if($mensaje->para_todos)
                                            Todos los trabajadores
                                        @else
                                            {{ optional($mensaje->destinatarios->first()?->user)->name }}
                                        @endif

                                    </td>

                                    {{-- Tipo --}}
                                    <td class="px-6 py-5">

                                        @if($mensaje->para_todos)

                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                Masivo
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                Individual
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Cantidad destinatarios --}}
                                    <td class="px-6 py-5 text-center">

                                        <span class="font-semibold text-gray-800">
                                            {{ $mensaje->destinatarios->count() }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-5 text-center">

                                        <a
                                            href="{{ route('admin.mensajes.show', $mensaje) }}"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-sky-100 text-sky-700 font-semibold hover:bg-sky-200 transition"
                                        >
                                            👁 Ver
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Paginación --}}
                <div class="px-8 py-5 border-t border-gray-100">

                    {{ $mensajes->links() }}

                </div>

            @else

                <div class="p-12 text-center">

                    <div class="text-5xl mb-4">
                        📭
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800">
                        Aún no hay mensajes enviados
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Cuando envíes mensajes a tus trabajadores aparecerán aquí.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>