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

            <!-- FORMULARIO -->
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

                <form method="POST" action="#">
                    @csrf

                    <div class="space-y-4">

                        <input type="text" placeholder="Nombre de la empresa"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <input type="text" placeholder="RUT de la empresa"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <input type="text" placeholder="Nombre del responsable"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <input type="email" placeholder="Correo electrónico"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <input type="tel" placeholder="Teléfono"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <input type="password" placeholder="Contraseña"
                               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

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

</body>
</html>