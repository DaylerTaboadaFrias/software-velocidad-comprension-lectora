<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus Fotografias') }}
        </h2>
        <br>
        <a href="{{ route('crear.fotografia',["evento" => $evento]) }}" class=" mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">REGISTRAR</a>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    
                    
                            
                            <div class="grid grid-cols-4 gap-4">
                                <!-- ... -->
                              
                                    @forelse ($fotografias as $fotografia)
                                    <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                        <a href="#">
                                            <img class="rounded-t-lg" src="{{ $fotografia->imagen }}" alt="" />
                                        </a>
                                        <div class="p-5">
                                            
                                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Visualizacion: {{ $fotografia->show }}</p>
                                            <form class="inline" method="POST" action="{{ route("fotografia.destroy", ["fotografia" => $fotografia,"evento" => $evento]) }}">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 mr-2 mb-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div> 
                                    @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"><td class="py-4 px-6">No hay registros</td></tr>
                                    @endforelse
                                </div>     
                                {{ $fotografias->links('pagination::tailwind') }}  
                        </div>
                         
                </div>
            </div>
        </div>
    </div>
    


</x-app-layout>
