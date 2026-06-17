<x-app-layout>
    <x-slot name="header">

        <div class="flex items-start justify-between">

            {{-- Título + subtítulo --}}
            <div>

                <h2 class="font-bold text-3xl text-gray-900 flex items-center gap-3">
                    👑 Administradores
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Gestiona los usuarios administradores de la empresa según tu plan.
                </p>

            </div>

            {{-- Botón --}}
            @if($administradores->count() < $limite)

                <a href="{{ route('admin.administradores.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold shadow transition">
                    + Nuevo Administrador
                </a>

            @else

                <span class="bg-gray-200 text-gray-500 px-4 py-2 rounded-lg shadow cursor-not-allowed">
                    Límite alcanzado
                </span>

            @endif

        </div>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-lg bg-red-50 p-4 text-red-800 border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Cards resumen --}}
            <div class="flex gap-4">

                <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 w-72">

                    <div class="text-sm text-gray-500">
                        👥 Administradores usados
                    </div>

                    <div class="mt-3 flex items-end gap-2">

                        <span class="text-4xl font-bold text-blue-600">
                            {{ $administradores->count() }}
                        </span>

                        <span class="text-lg text-gray-400 mb-1">
                            / {{ $limite }}
                        </span>

                    </div>

                </div>

            </div>

            <div class="bg-white shadow-md border border-gray-100 rounded-3xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>                            
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($administradores as $admin)

                            <tr class="hover:bg-gray-50 transition">
                                
                                <td class="px-6 py-5">

                                    <div class="font-semibold text-gray-900">
                                        👤 {{ $admin->name }}
                                    </div>

                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $admin->email }}
                                    </div>

                                </td>

                                <td class="px-6 py-4">
                                    @if($admin->rol === 'admin_primario')
                                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                                            Admin Primario
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                            Admin Secundario
                                        </span>
                                    @endif
                                </td>

                                {{-- ✅ ACCIONES --}}
                                <td class="px-6 py-4">
                                    @if($admin->rol === 'admin_secundario')
                                        <form method="POST"
                                            action="{{ route('admin.administradores.destroy', $admin) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('¿Eliminar este administrador?')"
                                                    class="text-red-600 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                            🔒 Protegido
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                    No hay administradores.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 transition text-white px-4 py-2 rounded-lg shadow">
                    ← Volver al dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>