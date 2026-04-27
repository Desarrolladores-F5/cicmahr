<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro exitoso - CICMA</title>
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
    <section class="min-h-[85vh] flex items-center justify-center px-6 py-16">

        <div class="max-w-3xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 px-8 py-10 md:px-16 md:py-12 text-center">

            <!-- ICONO -->
            <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-r from-blue-700 to-green-600 flex items-center justify-center text-white text-3xl mb-6">
                ✓
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Tu prueba gratuita ya está activa
            </h1>

            <p class="max-w-2xl mx-auto text-gray-600 text-lg leading-relaxed mb-8">
                Ya puedes comenzar a explorar CICMA y ordenar la gestión de personas de tu empresa.
                Durante 3 días tendrás acceso para conocer la plataforma sin compromiso.
            </p>

            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 md:p-7 text-left mb-8">
                <p class="font-semibold text-gray-900 mb-2">¿Qué puedes hacer ahora?</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✔ Revisar el panel principal</li>
                    <li>✔ Registrar trabajadores</li>
                    <li>✔ Explorar documentos, vacaciones y búsqueda avanzada</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-700 to-green-600 px-6 py-3 text-white font-semibold shadow hover:opacity-90 transition">
                        Ir a mi panel
                    </a>
                @endif

                <a href="/"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-6 py-3 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Volver al inicio
                </a>
            </div>

            <p class="text-xs text-gray-400 mt-6">
                Acceso seguro y directo a tu empresa.
            </p>

        </div>

    </section>

</body>
</html>