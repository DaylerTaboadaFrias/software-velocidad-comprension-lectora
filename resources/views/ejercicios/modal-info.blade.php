<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar ejercicio
        </h2>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">

                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('ejercicios.update', [$ejercicio->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="relative mb-4">
                                <label for="titulo" class="leading-7 text-sm text-gray-600">
                                    {{ __('titulo') }}
                                </label>
                                <input type="text" id="titulo" name="titulo"
                                    value="{{ old('titulo', $ejercicio->titulo) }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="relative mb-4">
                                <label for="recomendaciones" class="leading-7 text-sm text-gray-600">
                                    {{ __('Recomendaciones') }}
                                </label>
                                <input type="text" id="recomendaciones" name="recomendaciones"
                                    value="{{ old('recomendaciones', $ejercicio->recomendaciones) }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>

                            <div class="relative mb-4">
                                <label for="velocidad"
                                    class="leading-7 text-sm text-gray-600">{{ __('Velocidad') }}</label>
                                <input type="text" id="velocidad" name="velocidad"
                                    value="{{ old('velocidad', $ejercicio->velocidad) }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>

                            <div class="relative mb-4">
                                <label for="nivel_id"
                                    class="leading-7 text-sm text-gray-600">{{ __('Nivel') }}</label>
                                <select id="nivel_id" name="nivel_id"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach ($niveles as $nivel)
                                        @if ($nivel->id == $ejercicio->nivel_id)
                                            <option value="{{ $nivel->id }}" selected>
                                                {{ $nivel->nombre }}
                                            </option>
                                        @else
                                            <option value="{{ $nivel->id }}">
                                                {{ $nivel->nombre }}
                                            </option>
                                        @endIf
                                    @endforeach
                                </select>
                            </div>

                            <div class="relative mb-4">
                                <label for="tipo_id" class="leading-7 text-sm text-gray-600">
                                    {{ __('Tipo') }}
                                </label>
                                <select id="tipo_id" name="tipo_id"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    @foreach ($tipos as $tipo)
                                        @if ($tipo->id == $ejercicio->tipo_id)
                                            <option value="{{ $tipo->id }}" selected>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @else
                                            <option value="{{ $tipo->id }}">
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endIf
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lecturas -->
                            <x-lecturas-editor :lecturas="$lecturas" />


                            <!-- Botones -->
                            <div class="relative mb-4">

                                <button type="submit"
                                    class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Actualizar ejercicio
                                </button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
