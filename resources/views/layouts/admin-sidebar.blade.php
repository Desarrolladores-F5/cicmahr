<div class="fixed inset-y-0 left-0 w-72 bg-[#081028] text-white flex flex-col shadow-2xl">

    {{-- LOGO --}}
    <div class="px-8 py-8 border-b border-white/10">

        <img
            src="{{ asset('images/logo-cicmahr-transparente.png') }}"
            alt="CicmaHR"
            class="h-9"
        >

        <p class="text-sm text-gray-400 mt-3">
            Admin Panel
        </p>

    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-4 py-6 space-y-2">

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('dashboard')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>📊</span>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('trabajadores.index') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('trabajadores.*')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>👥</span>
            <span class="font-medium">Trabajadores</span>
        </a>

        <a href="{{ route('admin.vacaciones') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('vacaciones.*')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>🌴</span>
            <span class="font-medium">Vacaciones</span>
        </a>

        <a href="{{ route('busqueda.index') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('busqueda.*')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>🔎</span>
            <span class="font-medium">Búsqueda Avanzada</span>

        </a>

        <a href="{{ route('admin.mensajes.index') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('admin.mensajes.*')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>✉️</span>
            <span class="font-medium">Mensajería</span>

        </a>

        <a href="{{ route('suscripcion.index') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('suscripcion.*')
                ? 'bg-white/10 text-white shadow-lg'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <span>💳</span>
            <span class="font-medium">Mi Suscripción</span>

        </a>

    </nav>

    {{-- FOOTER --}}
    <div class="p-6 border-t border-white/10">

        <div class="bg-white/5 rounded-2xl p-4">

            <p class="text-xs text-gray-400 uppercase tracking-wider">
                Empresa
            </p>

            <p class="mt-1 font-semibold text-white">
                {{ auth()->user()->empresa->nombre ?? 'Empresa' }}
            </p>

        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf

            <button
                type="submit"
                class="w-full bg-red-500 hover:bg-red-600 transition rounded-2xl py-3 font-medium"
            >
                Cerrar sesión
            </button>

        </form>

    </div>

</div>