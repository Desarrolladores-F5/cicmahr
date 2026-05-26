<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recuperar contraseña — CicmaHR</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>

        <div class="min-h-screen flex bg-gray-100">

            {{-- PANEL IZQUIERDO --}}
            <div class="hidden lg:flex lg:w-1/2 bg-[#081028] relative overflow-hidden">

                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-green-500/10"></div>

                <div class="relative z-10 flex flex-col justify-center px-16 text-white">

                    <img
                        src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                        alt="CicmaHR"
                        class="w-72 mb-10"
                    >

                    <h1 class="text-5xl font-bold leading-tight mb-6">
                        Recupera el acceso a tu cuenta.
                    </h1>

                    <p class="text-lg text-gray-300 leading-relaxed max-w-xl">
                        Ingresa tu correo electrónico y te enviaremos un enlace
                        seguro para restablecer tu contraseña.
                    </p>

                    <div class="mt-12 flex items-center gap-4">

                        <div class="w-3 h-3 rounded-full bg-green-400"></div>

                        <p class="text-sm text-gray-400">
                            Recuperación segura de acceso
                        </p>

                    </div>

                </div>

            </div>

            {{-- PANEL DERECHO --}}
            <div class="flex-1 flex items-center justify-center px-6 py-12">

                <div class="w-full max-w-sm">

                    {{-- MOBILE LOGO --}}
                    <div class="lg:hidden flex justify-center mb-10">

                        <img
                            src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                            alt="CicmaHR"
                            class="w-52"
                        >

                    </div>

                    <div class="bg-white rounded-3xl shadow-2xl shadow-blue-500/10 p-10 border border-gray-100">

                        <div class="mb-8">

                            <h2 class="text-3xl font-bold text-gray-900">
                                ¿Olvidaste tu contraseña?
                            </h2>

                            <p class="text-gray-500 mt-2 leading-relaxed">
                                No te preocupes. Ingresa tu correo electrónico y
                                te enviaremos un enlace para recuperar el acceso
                                a tu cuenta.
                            </p>

                        </div>

                        {{-- SESSION STATUS --}}
                        <x-auth-session-status
                            class="mb-4"
                            :status="session('status')"
                        />

                        {{-- VALIDATION ERRORS --}}
                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mb-4"
                        />

                        <form method="POST" action="{{ route('password.email') }}">

                            @csrf

                            {{-- EMAIL --}}
                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                >

                            </div>

                            {{-- BOTÓN --}}
                            <div class="mt-8">

                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-green-500 hover:opacity-90 transition-all duration-200 text-white font-semibold py-3 rounded-2xl shadow-lg"
                                >
                                    Enviar enlace de recuperación
                                </button>

                            </div>

                            {{-- VOLVER LOGIN --}}
                            <div class="mt-6 text-center">

                                <a
                                    href="{{ route('login') }}"
                                    class="text-sm text-gray-500 hover:text-blue-600 transition"
                                >
                                    Volver al inicio de sesión
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </body>
</html>