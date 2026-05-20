@extends('layouts.superadmin')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Editar RUT Trabajador
            </h1>

            <p class="text-sm text-gray-500 mb-8">
                Corrección exclusiva para SuperAdmin.
            </p>

            <form action="{{ route('superadmin.trabajadores.updateRut', $trabajador) }}"
                method="POST"
                class="space-y-6">

                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Trabajador
                    </label>

                    <input type="text"
                        value="{{ $trabajador->nombre }} {{ $trabajador->apellido }}"
                        disabled
                        class="w-full rounded-xl border-gray-300 bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nuevo RUT
                    </label>

                    <input type="text"
                        name="rut"
                        value="{{ old('rut', $trabajador->rut) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('rut')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">

                    <button type="submit"
                        class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold transition">
                        Guardar cambios
                    </button>

                    <a href="{{ route('superadmin.empresas.show', $trabajador->empresa) }}"
                    class="text-sm text-gray-500 hover:text-gray-700">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection