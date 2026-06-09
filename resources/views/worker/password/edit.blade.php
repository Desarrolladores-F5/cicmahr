<x-app-layout>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-900">
                Cambiar contraseña 🔐
            </h1>

            <p class="mt-2 text-gray-500">
                Actualiza tu contraseña para mejorar la seguridad de tu cuenta.
            </p>

        </div>

        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8">

            <form method="POST" action="{{ route('worker.password.update') }}">

                @csrf
                @method('PATCH')

                {{-- Contraseña actual --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Contraseña actual
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring-sky-500 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('current_password', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            👁️
                        </button>
                    </div>

                    @error('current_password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nueva contraseña
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring-sky-500 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            👁️
                        </button>
                    </div>

                    @error('password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-8">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar nueva contraseña
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="w-full rounded-xl border-gray-300 focus:border-sky-500 focus:ring-sky-500 pr-12"
                            required
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            👁️
                        </button>
                    </div>

                </div>

                <div class="flex items-center gap-4">

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold transition"
                    >
                        Actualizar contraseña
                    </button>

                    <a
                        href="{{ route('worker.dashboard') }}"
                        class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);

            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }
    </script>

</x-app-layout>