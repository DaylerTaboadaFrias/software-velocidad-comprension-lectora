<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
        <br>
        
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
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-6">
                            Invitar 
                        </h2>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6">
                            <input type="email" id="correo" name="correo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Introduzca correo de la invitacion" required>
                            <button type="submit" class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mb-6">ENVIAR CORREO DE INVITACION</button>
                        </div>
                    </div>
                  
                  </div>
                
                
            </form>
                </div>
            </div>
        </div>
    </div>

        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Imagen
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Nombre
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Apellidos 
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Phone
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fotografos as $fotografo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="p-4 w-32">
                                        <img class="w-50 h-50 rounded-full" src="/images/{{ $fotografo->user->imagen }}" alt="image description">
                                    </td>
                                    
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$fotografo->user->name }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$fotografo->user->surnames }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$fotografo->user->phone }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            
                                            <form class="inline" method="POST" action="{{ route("fotografo.eliminar", ["user_event" => $fotografo->id]) }}">
                                                @csrf
                                                @method("POST")
                                                <button type="submit" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-transparent rounded-r-md border border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Eliminar
                                                </button>
                                            </form>
                                          </div>
                                    </td>
                                        
                                </tr>  
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"><td class="py-4 px-6">No hay registros</td></tr>
                            @endforelse
                            
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    


</x-app-layout>
