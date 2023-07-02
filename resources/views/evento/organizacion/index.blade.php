<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus Eventos') }}
        </h2>
        <br>
        <a href="{{ route('crear.evento') }}" class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">REGISTRAR</a>
    </x-slot>

    <div class="py-12">
        
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
                                    Evento
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Fecha 
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Hora Inicio
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Hora Fin
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($eventos as $evento)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="p-4 w-32">
                                        <img class="w-50 h-50 rounded-full" src="{{ $evento->imagen }}" alt="image description">
                                        <img src="{{ asset($evento->code_qr_imagen)}}" />
                                    </td>
                                    
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$evento->nombre }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$evento->fecha }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$evento->hora_inicio }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-gray-900 dark:text-white">
                                        {{$evento->hora_fin }}
                                    </td>
                                    <td class="py-4 px-6">
                                            <a href="{{ route("evento.edit", ["evento" => $evento]) }}">
                                                <button  class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    Editar
                                                  </button>
                                            </a>
                                            
                                            <form class="inline" method="POST" action="{{ route("evento.destroy", ["evento" => $evento]) }}">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Eliminar
                                                </button>
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
