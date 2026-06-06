<div class="fixed inset-y-0 left-0 w-72 bg-[#0369A1] text-white flex flex-col shadow-2xl overflow-y-auto">

    {{-- LOGO --}}
    <div class="px-8 py-8 border-b border-white/10">

        <img
            src="{{ asset('images/logo-cicmahr-transparente.png') }}"
            alt="CicmaHR"
            class="h-9"
        >

        <p class="text-sm text-gray-400 mt-3">
            Portal Trabajador
        </p>

    </div>

    @php
        $mensajesNoLeidos = \App\Models\MensajeUser::where('user_id', auth()->id())
            ->where('leido', false)
            ->count();
    @endphp

    {{-- MENU --}}
    <nav class="flex-1 px-4 py-6 space-y-2">

        <a href="{{ route('worker.dashboard') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all">

            <span>🏠</span>
            <span class="font-medium">Dashboard</span>

        </a>

        <a href="{{ route('worker.mensajes.index') }}"
            class="flex items-center justify-between px-5 py-4 rounded-2xl transition-all
            {{ request()->routeIs('worker.mensajes.*')
                ? 'bg-white/15 text-white shadow-lg'
                : 'text-white/90 hover:bg-white/10 hover:text-white' }}">

            <div class="flex items-center gap-3">
                <span>📨</span>
                <span class="font-medium">Mensajes</span>
            </div>

            @if($mensajesNoLeidos > 0)
                <span class="bg-red-500 text-white text-xs font-bold min-w-[24px] h-6 px-2 flex items-center justify-center rounded-full">
                    {{ $mensajesNoLeidos }}
                </span>
            @endif

        </a>

        <a href="{{ route('worker.documentos') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all">

            <span>📄</span>
            <span class="font-medium">Documentos</span>

        </a>

        <a href="{{ route('worker.horas_extras') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all">

            <span>⏱</span>
            <span class="font-medium">Horas Extras</span>

        </a>

        <a href="{{ route('worker.vacaciones') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all">

            <span>🌴</span>
            <span class="font-medium">Vacaciones</span>

        </a>

        <a href="{{ route('worker.reglamentos.index') }}"
            class="flex items-center gap-3 px-5 py-4 rounded-2xl transition-all">

            <span>📚</span>
            <span class="font-medium">Reglamentos</span>

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