<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="text-3xl font-bold text-gray-900">
                Planes CicmaHR 🚀
            </h2>

            <p class="text-gray-500 mt-2">
                Elige la duración que mejor se adapte a tu empresa.
            </p>
        </div>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

                @foreach($planes as $plan)

                    <div class="
                        relative rounded-3xl p-8 border transition-all duration-300
                        {{ $plan['destacado']
                            ? 'bg-gradient-to-br from-blue-500 via-indigo-500 to-violet-600 text-white shadow-2xl scale-105 border-transparent hover:-translate-y-2 hover:shadow-[0_25px_60px_rgba(79,70,229,0.35)]'
                            : 'bg-white border-gray-100 shadow-md hover:shadow-2xl hover:-translate-y-2'
                        }}
                    ">

                        {{-- BADGE --}}
                        @if($plan['destacado'])

                            <div class="absolute top-5 right-5">

                                <span class="bg-white/15 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur">
                                    ⭐ Más conveniente
                                </span>

                            </div>

                        @endif

                        {{-- ICON --}}
                        <div class="
                            w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-8
                            {{ $plan['destacado']
                                ? 'bg-white/10'
                                : 'bg-blue-50 text-blue-600'
                            }}
                        ">

                            💼

                        </div>

                        {{-- TITULO --}}
                        <h3 class="
                            text-2xl font-bold mb-3
                            {{ $plan['destacado']
                                ? 'text-white'
                                : 'text-gray-900'
                            }}
                        ">
                            {{ $plan['nombre'] }}
                        </h3>

                        {{-- DESCRIPCION --}}
                        <p class="
                            text-sm leading-relaxed mb-8
                            {{ $plan['destacado']
                                ? 'text-white/80'
                                : 'text-gray-500'
                            }}
                        ">
                            {{ $plan['descripcion'] }}
                        </p>

                        {{-- PRECIO --}}
                        <div class="mb-8">

                            <span class="
                                text-4xl font-extrabold
                                {{ $plan['destacado']
                                    ? 'text-white'
                                    : 'text-gray-900'
                                }}
                            ">
                                ${{ number_format($plan['precio'], 0, ',', '.') }}
                            </span>

                        </div>

                        {{-- BOTON --}}
                        <a href="{{ route('webpay.iniciar', $plan['meses']) }}"
                           class="
                                block w-full text-center py-4 rounded-2xl font-semibold transition-all
                                {{ $plan['destacado']
                                    ? 'bg-white text-indigo-600 hover:bg-gray-100'
                                    : 'bg-gray-900 text-white hover:bg-black'
                                }}
                           ">

                            Continuar al pago

                        </a>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</x-app-layout>