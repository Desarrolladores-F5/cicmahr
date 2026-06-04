<x-app-layout>

    <div class="p-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Nuevo mensaje ✉️
                </h1>

                <p class="mt-2 text-gray-500">
                    Envía una comunicación interna a uno o todos los trabajadores.
                </p>
            </div>

            <a href="{{ route('admin.mensajes.index') }}"
               class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition">
                Volver
            </a>

        </div>

        {{-- Card formulario --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 max-w-4xl">

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.mensajes.store') }}">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Título
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        value="{{ old('titulo') }}"
                        class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Ej: Recordatorio importante"
                    >
                </div>

                {{-- Mensaje --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Mensaje
                    </label>

                    <textarea
                        name="mensaje"
                        rows="6"
                        class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Escribe aquí el mensaje para el trabajador o grupo de trabajadores..."
                    >{{ old('mensaje') }}</textarea>
                </div>

                {{-- Enviar a todos --}}
                <div class="mb-6 bg-blue-50 border border-blue-100 rounded-2xl p-5">

                    <label class="flex items-start gap-3 cursor-pointer">

                        <input
                            type="checkbox"
                            name="para_todos"
                            value="1"
                            class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('para_todos') ? 'checked' : '' }}
                        >

                        <div>
                            <p class="font-semibold text-gray-800">
                                Enviar a todos los trabajadores
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Si marcas esta opción, el mensaje será enviado a todos los trabajadores activos de la empresa.
                            </p>
                        </div>

                    </label>

                </div>

                {{-- Trabajador específico --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Trabajador específico
                    </label>

                    <select
                        name="user_id"
                        class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">
                            Selecciona un trabajador
                        </option>

                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}"
                                {{ old('user_id') == $trabajador->id ? 'selected' : '' }}>
                                {{ $trabajador->name }} — {{ $trabajador->email }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-sm text-gray-400 mt-2">
                        Usa este campo solo si no enviarás el mensaje a todos.
                    </p>
                </div>

                {{-- Botones --}}
                <div class="flex items-center gap-4">

                    <button
                        type="submit"
                        class="px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all"
                    >
                        Enviar mensaje
                    </button>

                    <a href="{{ route('admin.mensajes.index') }}"
                       class="px-6 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>