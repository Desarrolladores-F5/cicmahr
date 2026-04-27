<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CicmaHR</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-white text-gray-800">

        <!-- NAVBAR -->
        <header class="w-full bg-gray-900 text-white border-b border-gray-800">
            <div class="max-w-[1500px] mx-auto px-4 md:px-6 py-4 flex items-center justify-between">

                <!-- LOGO REAL -->
                <a href="/" class="flex items-center shrink-0">
                    <img src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                        alt="CicmaHR"
                        class="h-6 md:h-8 w-auto object-contain transition duration-300 hover:opacity-90">
                </a>

                <!-- ACCESO -->
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                    class="inline-flex items-center rounded-xl border border-gray-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800 transition">
                        Acceso
                    </a>
                @endif

            </div>
        </header>

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center px-6 pt-24 md:pt-28 pb-16">
            <div class="max-w-7xl mx-auto w-full grid md:grid-cols-2 gap-12 items-center">

                <!-- TEXTO -->
                <div>
                    <span class="inline-flex items-center rounded-full bg-blue-50 text-blue-700 px-4 py-1 text-sm font-medium mb-6">
                        Plataforma SaaS para gestión de RRHH
                    </span>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-gray-900 mb-6">
                        Gestión de personas
                        <span class="text-blue-700">simple, legal y eficiente</span>
                    </h1>

                    <p class="text-lg md:text-xl text-gray-600 mb-4 leading-relaxed">
                        Una plataforma de recursos humanos funcional y escalable, pensada para pequeñas y medianas empresas que buscan una solución confiable, accesible y con un trato cercano.
                    </p>

                    <p class="text-base text-gray-500 mb-8 leading-relaxed">
                        Controla trabajadores, vacaciones, documentos e historial en un solo lugar, con una experiencia clara y adaptada a la realidad chilena.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-6 py-3 text-white font-semibold shadow-md hover:bg-blue-800 transition">
                                Comienza hoy
                            </a>
                        @endif

                        <a href="#funcionalidades"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-6 py-3 font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Ver funcionalidades
                        </a>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4 text-sm text-gray-500">
                        <span>✔ Gestión simple</span>
                        <span>✔ Cercanía real</span>
                        <span>✔ Pensado para PYMES</span>
                        <span>✔ Sin instalaciones y con Acceso inmediato.</span>
                    </div>
                    
                </div>

                <!-- MOCKUP VISUAL -->
                <div class="hidden md:block">
                    <div class="relative rounded-3xl border border-gray-200 bg-white shadow-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-700 via-green-600 to-rose-800 h-3 w-full"></div>

                        <div class="p-6">
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="rounded-2xl bg-blue-50 p-4">
                                    <p class="text-sm text-gray-500">Trabajadores</p>
                                    <p class="text-2xl font-bold text-blue-700">128</p>
                                </div>
                                <div class="rounded-2xl bg-green-50 p-4">
                                    <p class="text-sm text-gray-500">Vacaciones</p>
                                    <p class="text-2xl font-bold text-green-700">12</p>
                                </div>
                                <div class="rounded-2xl bg-rose-50 p-4">
                                    <p class="text-sm text-gray-500">Documentos</p>
                                    <p class="text-2xl font-bold text-rose-800">324</p>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-100 p-4 mb-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Resumen general</p>
                                <div class="space-y-3">
                                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-4/5 bg-blue-700 rounded-full"></div>
                                    </div>
                                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-3/5 bg-green-600 rounded-full"></div>
                                    </div>
                                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full w-2/3 bg-rose-800 rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Búsqueda avanzada</p>
                                <div class="rounded-xl bg-white border border-gray-200 px-4 py-3 text-gray-400 text-sm">
                                    Buscar trabajadores, documentos o historial...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- FUNCIONALIDADES PRO -->
        <section id="funcionalidades" class="py-24 bg-blue-50 border-t border-blue-100">

            <div class="max-w-[1300px] mx-auto px-4 md:px-6">

                <!-- TÍTULO -->
                <div class="max-w-3xl mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                        Conoce cómo CicmaHR simplifica la gestión de tu empresa
                    </h2>
                    <p class="text-lg text-gray-600">
                        Explora las principales funcionalidades que te permitirán ordenar, controlar y optimizar la gestión de personas.
                    </p>
                </div>

                <!-- TABS -->
                <div class="flex flex-wrap gap-3 mb-10">

                    <button class="tab-btn active px-5 py-2 rounded-xl bg-blue-600 text-white font-medium" data-tab="tab1">
                        Trabajadores
                    </button>

                    <button class="tab-btn px-5 py-2 rounded-xl bg-gray-100 text-gray-700 font-medium" data-tab="tab2">
                        Vacaciones
                    </button>

                    <button class="tab-btn px-5 py-2 rounded-xl bg-gray-100 text-gray-700 font-medium" data-tab="tab3">
                        Documentos
                    </button>

                    <button class="tab-btn px-5 py-2 rounded-xl bg-gray-100 text-gray-700 font-medium" data-tab="tab4">
                        Búsqueda
                    </button>

                </div>

                <!-- CONTENIDO -->
                <div class="grid md:grid-cols-2 gap-12 items-center">

                    <!-- TEXTO -->
                    <div id="tab-content">

                        <!-- TAB 1 -->
                        <div class="tab-pane" data-tab="tab1">
                            <h3 class="text-2xl font-semibold mb-4">Gestión de trabajadores</h3>
                            <p class="text-gray-600 mb-4">
                                Controla tu equipo sin planillas desordenadas.
                                Toda la información de tus trabajadores en un solo lugar, clara y accesible.
                            </p>
                            <p class="text-gray-500 text-sm">
                                Olvídate de planillas desordenadas y accede a todo en segundos.
                            </p>
                        </div>

                        <!-- TAB 2 -->
                        <div class="tab-pane hidden" data-tab="tab2">
                            <h3 class="text-2xl font-semibold mb-4">Gestión de vacaciones</h3>
                            <p class="text-gray-600 mb-4">
                                Gestiona vacaciones sin errores ni confusiones.
                                Visualiza estados, fechas y solicitudes de forma ordenada y simple.
                            </p>
                            <p class="text-gray-500 text-sm">
                                Mantén el orden interno y mejora la planificación del equipo.
                            </p>
                        </div>

                        <!-- TAB 3 -->
                        <div class="tab-pane hidden" data-tab="tab3">
                            <h3 class="text-2xl font-semibold mb-4">Gestión de documentos</h3>
                            <p class="text-gray-600 mb-4">
                                Olvídate de perder documentos importantes, 
                                centraliza contratos y archivos en un sistema seguro y siempre disponible.
                            </p>
                            <p class="text-gray-500 text-sm">
                                Todo cuando lo necesites.
                            </p>
                        </div>

                        <!-- TAB 4 -->
                        <div class="tab-pane hidden" data-tab="tab4">
                            <h3 class="text-2xl font-semibold mb-4">Búsqueda inteligente</h3>
                            <p class="text-gray-600 mb-4">
                                Encuentra cualquier información en segundos con un buscador avanzado
                                accediendo a cualquier dato o documento con un buscador rápido y preciso.
                            </p>
                            <p class="text-gray-500 text-sm">
                                Ahorra tiempo y toma decisiones más rápido.
                            </p>
                        </div>

                    </div>

                    <!-- IMAGEN -->
                    <div>
                        <img id="tab-image" src="/images/dashboard-preview.png"
                            class="rounded-3xl shadow-xl border border-gray-200">
                    </div>

                </div>

            </div>

        </section>

        <!-- BENEFICIOS -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-3xl mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Una plataforma cercana, clara y preparada para crecer contigo
                    </h2>
                    <p class="text-lg text-gray-600">
                        CicmaHR busca entregar una alternativa accesible y confiable para empresas que necesitan orden, control y una experiencia más humana.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-500">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4 text-blue-700 font-bold">
                            01
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Gestión simple</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Administra información clave de tus trabajadores sin depender de procesos desordenados o planillas difíciles de mantener.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-500">
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-4 text-green-700 font-bold">
                            02
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Pensado para PYMES</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Una solución más accesible y coherente con la realidad de empresas que necesitan eficiencia sin asumir costos excesivos.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-500">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center mb-4 text-rose-800 font-bold">
                            03
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Trato cercano</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Detrás de CicmaHR hay una microempresa con atención directa, acompañamiento real y una mirada humana del servicio.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-500">
                        <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center mb-4 text-gray-700 font-bold">
                            04
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Escalable</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Parte con lo esencial hoy y sigue creciendo mañana con una base sólida para nuevas funciones y mejoras continuas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section class="py-24 bg-gradient-to-r from-blue-700 via-blue-600 to-green-600 text-white">
            <div class="max-w-5xl mx-auto px-6 text-center">

                <!-- TÍTULO -->
                <h2 class="text-3xl md:text-4xl font-bold mb-6 leading-tight">
                    Comienza hoy y simplifica la gestión de tu empresa
                </h2>

                <!-- TEXTO -->
                <p class="text-lg text-blue-100 mb-10 max-w-2xl mx-auto">
                    CicmaHR está diseñado para ayudarte a ordenar, controlar y mejorar la gestión de personas 
                    en tu empresa, con una solución clara, accesible y cercana.
                </p>

                <!-- BOTÓN -->
                @if (Route::has('registro'))
                    <a href="{{ route('registro') }}"
                    class="inline-flex items-center justify-center bg-white text-blue-700 font-semibold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-100 transition duration-300 hover:scale-105">
                        Registrarme
                    </a>
                @endif

                <!-- REFUERZO -->
                <p class="text-sm text-blue-200 mt-6">
                    Sin instalaciones. Acceso inmediato.
                </p>

            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-gray-900 text-gray-300 py-16">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">

                <!-- MARCA -->
                <div>
                    <a href="/" class="inline-flex items-center mb-4">
                        <img src="{{ asset('images/logo-cicmahr-transparente.png') }}"
                            alt="CICMA"
                            class="h-10 w-auto object-contain transition duration-300 hover:opacity-90">
                    </a>

                    <p class="text-gray-400 text-sm leading-relaxed">
                        Plataforma de gestión de recursos humanos diseñada para pequeñas y medianas empresas.
                        Simplicidad, control y cercanía en un solo lugar.
                    </p>
                </div>

                <!-- LINKS -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Plataforma</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#beneficios" class="hover:text-white transition">Beneficios</a></li>
                        <li><a href="#funcionalidades" class="hover:text-white transition">Funcionalidades</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>

                <!-- ACCESO -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Acceso</h4>

                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center bg-white text-gray-900 font-semibold px-6 py-3 rounded-xl shadow hover:bg-gray-200 transition duration-300">
                            Ingresar a la plataforma
                        </a>
                    @endif

                    <p class="text-sm text-gray-500 mt-4">
                        Acceso seguro y directo a tu empresa.
                    </p>
                </div>

            </div>

            <!-- BOTTOM -->
            <div class="border-t border-gray-800 mt-12 pt-6 text-center text-sm text-gray-500">
                © {{ date('Y') }} CICMA. Todos los derechos reservados.
            </div>
        </footer>


        <!-- SCRIPT DEL BLOQUE FUNCIONALIDADES PRO -->
        <script>
            const buttons = document.querySelectorAll('.tab-btn');
            const panes = document.querySelectorAll('.tab-pane');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {

                    // reset botones
                    buttons.forEach(b => {
                        b.classList.remove('bg-blue-600', 'text-white');
                        b.classList.add('bg-gray-100', 'text-gray-700');
                    });

                    // activar botón
                    btn.classList.add('bg-blue-600', 'text-white');
                    btn.classList.remove('bg-gray-100', 'text-gray-700');

                    // mostrar contenido
                    panes.forEach(p => p.classList.add('hidden'));

                    document.querySelector(`[data-tab="${btn.dataset.tab}"].tab-pane`)
                        .classList.remove('hidden');
                });
            });
        </script>

    </body>
</html>