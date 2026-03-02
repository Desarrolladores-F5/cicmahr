<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administradores
            </h2>

            @if($administradores->count() < $limite)
                <a href="{{ route('admin.administradores.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
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

            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="p-4 border-b text-sm text-gray-600">
                    Límite del plan: <span class="font-semibold">{{ $limite }}</span> administradores
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>

                            {{-- ✅ NUEVA COLUMNA --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($administradores as $admin)
                            <tr>
                                <td class="px-6 py-4">{{ $admin->name }}</td>
                                <td class="px-6 py-4">{{ $admin->email }}</td>

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
                                        <span class="text-gray-400 text-sm">
                                            Protegido
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