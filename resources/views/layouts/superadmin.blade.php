<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin — CicmaHR</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-gray-900 text-white flex flex-col shadow-2xl">

            {{-- LOGO --}}
            <div class="px-6 py-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold tracking-wide">
                    CICMA<span class="text-blue-400">HR</span>
                </h1>

                <p class="text-xs text-gray-400 mt-1">
                    SuperAdmin Panel
                </p>
            </div>

            {{-- NAV --}}
            <nav class="flex-1 px-4 py-6 space-y-2">

                <a href="{{ route('superadmin.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 transition">

                    <span class="mr-3">📊</span>
                    Dashboard
                </a>

                <a href="{{ route('superadmin.empresas.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gray-800 transition">

                    <span class="mr-3">🏢</span>
                    Empresas
                </a>

                <a href="{{ route('superadmin.pagos.index') }}"
                   class="flex items-center px-4 py-3 rounded-xl hover:bg-gray-800 transition">

                    <span class="mr-3">💳</span>
                    Pagos
                </a>

                <a href="{{ route('superadmin.auditoria.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl hover:bg-gray-800 transition">

                    <span class="mr-3">📜</span>
                    Auditoría
                </a>

                <a href="#"
                   class="flex items-center px-4 py-3 rounded-xl hover:bg-gray-800 transition">

                    <span class="mr-3">⚙️</span>
                    Configuración
                </a>

            </nav>

            {{-- FOOTER SIDEBAR --}}
            <div class="p-4 border-t border-gray-800 text-xs text-gray-500">
                CicmaHR SaaS Platform
            </div>

        </aside>

        {{-- CONTENIDO --}}
        <div class="flex-1 flex flex-col">

            {{-- TOPBAR --}}
            <header class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 flex items-center justify-between">

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $title ?? 'SuperAdmin' }}
                    </h2>
                </div>

                <div class="flex items-center gap-4">

                    <span class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-xs font-semibold text-white">
                        SUPERADMIN
                    </span>

                    <div class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </div>

                    {{-- LOGOUT --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 transition">
                            Salir
                        </button>
                    </form>

                </div>

            </header>

            {{-- MAIN --}}
            <main class="flex-1 p-8">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>