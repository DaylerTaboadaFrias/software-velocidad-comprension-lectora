<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus Ofertas de Trabajos') }}
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
                                    Organización de eventos
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Evento
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Monto por evento
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Estado 
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Fecha 
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ofertas as $oferta)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="p-4 w-32">
                                        <img class="w-50 h-50 rounded-full" src="/images/{{ $oferta->organizacion->photo1 }}" alt="image description">
                                    </td>
                                    
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$oferta->organizacion->name }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$oferta->evento->nombre }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$oferta->amount_event.' Bs.' }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$oferta->state }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{$oferta->created_at }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if ($oferta->state == 'Pendiente')
                                        <form class="inline" method="POST" action="{{ route("oferta.aceptar", ["offer" => $oferta]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                  </svg>
                                            ACEPTAR
                                            </button>
                                        </form>
                                        <form class="inline" method="POST" action="{{ route("oferta.rechazar", ["offer" => $oferta]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            RECHAZAR
                                            </button>
                                        </form>
                                        @else
                                            @if ($oferta->state == 'Aceptada')
                                            <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">ACEPTADA</span>
                                            @endif
                                            @if ($oferta->state == 'Rechazada')
                                            <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">RECHAZADA</span>
                                            @endif
                                        

                                        @endif
                                        
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
