<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar ejercicio
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

                    <form method="POST" action="{{ route('ejercicios.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">
                                {{ __('Introduce tus datos') }}
                            </h2>

                            <!-- Recomendaciones -->
                            <div class="relative mb-4">
                                <label for="titulo"
                                    class="leading-7 text-sm text-gray-600">{{ __('titulo') }}</label>
                                <input type="text" id="titulo" name="titulo"
                                    value="{{ old('titulo') }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                @error('titulo')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative mb-4">
                                <label for="recomendaciones"
                                    class="leading-7 text-sm text-gray-600">{{ __('Recomendaciones') }}</label>
                                <input type="text" id="recomendaciones" name="recomendaciones"
                                    value="{{ old('recomendaciones') }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                @error('recomendaciones')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Velocidad -->
                            <div class="relative mb-4">
                                <label for="velocidad"
                                    class="leading-7 text-sm text-gray-600">{{ __('Velocidad') }}</label>
                                <input type="text" id="velocidad" name="velocidad" value="{{ old('velocidad') }}"
                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                @error('velocidad')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nivel -->
                            <div class="relative mb-4">
                                <label for="nivel_id"
                                    class="leading-7 text-sm text-gray-600">{{ __('Nivel') }}</label>

                                <div class="relative">
                                    <select
                                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="nivel_id" name="nivel_id">
                                        @foreach ($niveles as $nivel)
                                            <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('nivel')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo -->
                            <div class="relative mb-4">
                                <label for="tipo_id"
                                    class="leading-7 text-sm text-gray-600">{{ __('Tipo') }}</label>

                                <div class="relative">
                                    <select
                                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="tipo_id" name="tipo_id">
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('tipo')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lecturas -->
                            <x-lecturas-editor />

                            <!-- Button Guardar -->
                            <div class="relative mb-4">
                                <button type="submit"
                                    class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Guardar ejercicio
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
