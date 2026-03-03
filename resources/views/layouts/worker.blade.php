<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal Trabajador - CicmaHR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-gray-800">
                CicmaHR — Portal Trabajador
            </h1>

            <div class="flex items-center gap-4 text-sm text-gray-600">

                <span>{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto px-6 py-3 flex gap-6 text-sm">
            <a href="{{ route('worker.dashboard') }}" class="hover:text-blue-600">
                Dashboard
            </a>
            <a href="#" class="hover:text-blue-600">
                Mis Documentos
            </a>
            <a href="#" class="hover:text-blue-600">
                Perfil
            </a>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">
            @yield('content')
        </div>
    </main>

</body>
</html>