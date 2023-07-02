<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus fotografos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-balck-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Logo
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Nombre
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Tel/Cel.
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Email
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Despedir
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="p-4 w-32">
                                        <img class="w-50 h-50 rounded-full" src="{{ $usuario->photo1 }}" alt="image description">
                                    </td>
                                    
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$usuario->name .' '. $usuario->lastname }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$usuario->phone }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$usuario->email }}
                                    </td>
                                    <td class="py-4 px-6">
                                       
                                        <form class="inline" method="POST" action="{{ route("trabajador.despedir", ["user" => $usuario]) }}">
                                            @csrf
                                            @method("POST")
                                            <div class="grid gap-2 mb-2 md:grid-cols-2">
                                                <div>
                                                    <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                          </svg>
                                                          
                                                    DESPEDIR
                                                    </button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                        
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
    </div>
    


</x-app-layout>
