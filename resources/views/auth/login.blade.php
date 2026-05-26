<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login — CicmaHR</title>

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
                        Gestiona tu empresa de forma moderna.
                    </h1>

                    <p class="text-lg text-gray-300 leading-relaxed max-w-xl">
                        Plataforma SaaS para administración de trabajadores,
                        documentos, vacaciones, pagos y gestión empresarial.
                    </p>

                    <div class="mt-12 flex items-center gap-4">

                        <div class="w-3 h-3 rounded-full bg-green-400"></div>

                        <p class="text-sm text-gray-400">
                            Plataforma activa y segura
                        </p>

                    </div>

                </div>

            </div>

            {{-- PANEL DERECHO --}}
            <div class="flex-1 flex items-center justify-center px-6 py-12">

                <div class="w-full max-w-md">

                    {{-- MOBILE LOGO --}}
                    <div class="lg:hidden flex justify-center mb-10">

                        <img
                            src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                            alt="CicmaHR"
                            class="w-52"
                        >

                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100">

                        <div class="mb-8">

                            <h2 class="text-3xl font-bold text-gray-900">
                                Bienvenido
                            </h2>

                            <p class="text-gray-500 mt-2">
                                Ingresa a tu cuenta CicmaHR
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

                        <form method="POST" action="{{ route('login') }}">

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

                            {{-- PASSWORD --}}
                            <div class="mt-6">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    required
                                    class="w-full rounded-2xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                >

                            </div>

                            {{-- REMEMBER --}}
                            <div class="mt-6 flex items-center">

                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                    name="remember"
                                >

                                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                                    Recordarme
                                </label>

                            </div>

                            {{-- ACTIONS --}}
                            <div class="mt-8">

                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-green-500 hover:opacity-90 transition-all duration-200 text-white font-semibold py-3 rounded-2xl shadow-lg"
                                >
                                    Ingresar a CicmaHR
                                </button>

                            </div>

                            {{-- FORGOT PASSWORD --}}
                            @if (Route::has('password.request'))

                                <div class="mt-6 text-center">

                                    <a
                                        class="text-sm text-gray-500 hover:text-blue-600 transition"
                                        href="{{ route('password.request') }}"
                                    >
                                        ¿Olvidaste tu contraseña?
                                    </a>

                                </div>

                            @endif

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </body>

</html>