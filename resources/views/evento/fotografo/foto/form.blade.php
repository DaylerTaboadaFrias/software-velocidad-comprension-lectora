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
                @if($fotografia->id)
                    @method("PUT")
                @endif
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <div class="relative mb-4">
                        <label for="notify" class="leading-7 text-sm text-gray-600">{{ __("Notificacion push :") }}</label>
                        <select hidden id="notify" name="notify" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <option  value="Si">Si</option>
                                <option  value="No">No</option>
                        </select>
                    </div>
                    <div class="relative mb-4">
                        <label for="show" class="leading-7 text-sm text-gray-600">{{ __("Visualización :") }}</label>
                        <select id="show" name="show" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <option  value="Cliente">Solo la persona</option>
                                <option  value="Todos">Todas la personas</option>
                        </select>
                    </div>
                    <div class="relative mb-4">
                        <label class="leading-7 text-sm text-gray-600" for="multiple_files">Elija las imagenes a cargar :</label>
                        <input multiple name="files[]" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="imagen" type="file">   
                        <button type="submit" class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{ $title }}</button>
                    </div>
                    
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    


</x-app-layout>
