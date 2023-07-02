<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
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
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data"> 
                @csrf
                @if($evento->id)
                    @method("PUT")
                @endif
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">{{ __("Escribe tu evento") }}</h2>
                    <div class="relative mb-4">
                        <label for="nombre" class="leading-7 text-sm text-gray-600">{{ __("Título") }}</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old("nombre", $evento->nombre) }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    
                    <div class="relative mb-4">
                        <label for="detalle" class="leading-7 text-sm text-gray-600">{{ __("Direccion") }}</label>
                        <textarea id="detalle" name="detalle" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old("descripcion", $evento->detalle) }}</textarea>
                    </div>
                    <div class="relative mb-4">
                        <label for="direccion" class="leading-7 text-sm text-gray-600">{{ __("Descripcion") }}</label>
                        <textarea id="direccion" name="direccion" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ old("direccion", $evento->direccion) }}</textarea>
                    </div>
                    <div class="relative mb-4">
                        <label for="type_event_id" class="leading-7 text-sm text-gray-600">{{ __("Tipo de evento") }}</label>
                        <select id="type_event_id" name="type_event_id" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @foreach(\App\Models\TypeEvent::get() as $typeEvent)
                                <option {{ (int) old("type_event_id", $typeEvent->type_event_id) === $evento->id ? 'selected' : '' }} value="{{ $typeEvent->id }}">{{ $typeEvent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative mb-4">
                        <label for="cantidad_personas" class="leading-7 text-sm text-gray-600">{{ __("Cantidad de personas") }}</label>
                        <input type="number" id="cantidad_personas" name="cantidad_personas" value="{{ old("cantidad_personas", $evento->cantidad_personas) }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="fecha" class="leading-7 text-sm text-gray-600">{{ __("Fecha") }}</label>
                        <input type="date" id="fecha" name="fecha" value="{{ old("fecha", $evento->fecha) }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="hora_inicio" class="leading-7 text-sm text-gray-600">{{ __("Hora de inicio") }}</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old("hora_inicio", $evento->hora_inicio) }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="hora_fin" class="leading-7 text-sm text-gray-600">{{ __("Hora fin") }}</label>
                        <input type="time" id="hora_fin" name="hora_fin" value="{{ old("hora_fin", $evento->hora_fin) }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label class="leading-7 text-sm text-gray-600" for="multiple_files">Elija una imagen para el evento</label>
                        <input name="imagen" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="imagen" type="file">   
                        <button type="submit" class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ $title }}</button>
                    </div>
                    
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    


</x-app-layout>
