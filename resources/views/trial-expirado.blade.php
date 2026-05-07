<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Trial finalizado</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-50 text-gray-800">

        <header class="w-full bg-gray-900 text-white py-4 px-6">
            <img src="{{ asset('images/logo-cicmahr-transparente.png') }}" class="h-10">
        </header>

        <section class="min-h-[80vh] flex items-center justify-center px-6">

            <div class="max-w-xl w-full bg-white p-10 rounded-3xl shadow-xl text-center">

                <h1 class="text-3xl font-bold mb-4 text-gray-900">
                    Tu prueba ha finalizado
                </h1>

                <p class="text-gray-600 mb-8">
                    Para seguir utilizando CicmaHR, activa tu cuenta y continúa gestionando tu empresa sin interrupciones.
                </p>

                <a href="{{ route('activar.cuenta') }}"
                class="inline-block bg-gradient-to-r from-blue-700 to-green-600 text-white px-6 py-3 rounded-xl font-semibold shadow">
                    Activar cuenta
                </a>

                <div class="mt-6">
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-sm text-gray-500 hover:text-gray-700">
                        Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>

            </div>

        </section>

    </body>
</html>