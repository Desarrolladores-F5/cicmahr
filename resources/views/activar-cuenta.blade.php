<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Activar cuenta</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-50 text-gray-800">

        <header class="w-full bg-gray-900 text-white py-4 px-6">
            <img src="{{ asset('images/logo-cicmahr-transparente.png') }}" class="h-10">
        </header>

        <section class="min-h-[80vh] flex items-center justify-center px-6">

            <div class="max-w-xl w-full bg-white p-10 rounded-3xl shadow-xl text-center">

                <h1 class="text-3xl font-bold mb-4">
                    Activa tu cuenta
                </h1>

                <p class="text-gray-600 mb-8">
                    Continúa utilizando CicmaHR sin límites por un único precio mensual.
                </p>

                <div class="bg-gray-50 border rounded-xl p-6 mb-6">
                    <p class="text-2xl font-bold text-gray-900">$9.990 / mes</p>
                    <p class="text-sm text-gray-500">Acceso completo a la plataforma</p>
                </div>

                <a href="{{ route('webpay.iniciar') }}"
                   class="w-full inline-block bg-gradient-to-r from-blue-700 to-green-600 text-white py-3 rounded-xl font-semibold shadow">
                    Pagar y activar cuenta
                </a>

            </div>

        </section>

    </body>
</html>