<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro - CicmaHR</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-50 text-gray-800">

        <!-- NAVBAR SIMPLE -->
        <header class="w-full bg-gray-900 text-white py-4 px-6">
            <div class="max-w-[1400px] mx-auto">    <!-- acá movemos el logo para la izq cambiando el número -->
                <a href="/" class="inline-flex items-center">
                    <img src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                        class="h-10 object-contain"
                        alt="CICMA">
                </a>
            </div>
        </header>

        <!-- CONTENIDO -->
        <section class="min-h-[90vh] flex items-center justify-center px-6 py-16">

            <div class="max-w-4xl w-full grid md:grid-cols-2 gap-12 items-center">

                <!-- TEXTO -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">
                        Comienza tu prueba gratuita
                    </h1>

                    <p class="text-gray-600 mb-6">
                        Accede a CicmaHR por 3 días sin compromiso y descubre cómo simplificar la gestión de tu empresa.
                    </p>

                    <ul class="space-y-3 text-sm text-gray-500">
                        <li>✔ Sin instalaciones</li>
                        <li>✔ Acceso inmediato</li>
                        <li>✔ Soporte directo</li>
                    </ul>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">
                        <ul class="space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORMULARIO -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

                    <form method="POST" action="{{ route('registro.store') }}">
                        @csrf

                        <div class="space-y-4">

                            <input type="text"
                                name="empresa"
                                placeholder="Nombre de la empresa"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <input type="text"
                                name="rut"
                                placeholder="RUT empresa 12345678-9"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <input type="text"
                                name="nombre"
                                placeholder="Nombre del responsable"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <input type="email"
                                name="email"
                                placeholder="correo@empresa.cl"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <input type="tel"
                                name="telefono"
                                placeholder="+56 9 1234 5678"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <!-- Contraseña con ojito -->
                            <div class="relative">
                                <input type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Contraseña"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <button type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    👁
                                </button>
                            </div>

                            <!-- Confirmar contraseña con ojito -->
                            <div class="relative">
                                <input type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Confirmar contraseña"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <button type="button"
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    👁
                                </button>
                            </div>

                        </div>

                        <!-- BOTÓN -->
                        <button type="submit"
                            class="w-full mt-6 bg-gradient-to-r from-blue-700 to-green-600 text-white font-semibold py-3 rounded-lg hover:opacity-90 transition">
                            Crear cuenta y comenzar
                        </button>

                        <p class="text-xs text-gray-400 mt-4 text-center">
                            No se requiere tarjeta de crédito.
                        </p>

                    </form>

                </div>

            </div>

        </section>

        <script>     // Función para mostrar/ocultar contraseña
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);

                if (input.type === 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            }
        </script>

    </body>
</html>