<x-app-layout>

<div class="max-w-5xl mx-auto py-10">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Mis Documentos
    </h2>

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Documento
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Fecha
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        Acción
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @forelse($documentos as $doc)

                <tr>

                    <td class="px-6 py-4 text-gray-800 font-medium">
                        {{ $doc->tipoDocumento->nombre_documento ?? 'Documento' }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($doc->fecha_documento)->format('d-m-Y') }}
                    </td>

                    <td class="px-6 py-4 text-right">

                        <a href="{{ route('worker.documentos.download', $doc) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">

                           Descargar
                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                        No tienes documentos disponibles.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>