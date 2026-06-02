<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.admin-sidebar')

            @if(session('superadmin_id'))
                <div class="bg-yellow-50 border-b border-yellow-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                        <p class="text-sm font-medium text-yellow-800">
                            ⚠️ Estás operando en modo soporte como administrador de empresa.
                        </p>

                        <form action="{{ route('superadmin.volver') }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-xs px-4 py-2 rounded-lg transition">
                                Volver a SuperAdmin
                            </button>
                        </form>
                    </div>
                </div>
            @endif


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-200 ml-72">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="ml-72 p-8">
                {{ $slot }}
            </main>
        </div>
        
    </body>
</html>
