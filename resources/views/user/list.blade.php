<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar usuarios') }}
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
                                    Foto
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Nombre
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Email
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Rol
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Banned
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="">
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        <img src="{{ $user->photo1 }}" alt=""
                                            style="width: auto; height: 56px; border-radius: 8px">
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        {{ $user->role }}
                                    </td>
                                    <td class="py-4 px-6  text-gray-900 dark:text-white">
                                        <!-- Banned -->
                                        <form method="POST" action="/users/{{ $user->banned ? 'notbanned': 'banned' }}/{{ $user->id }}">
                                            @csrf
                                            <input id="red-checkbox" type="checkbox" value=""
                                                onchange="event.preventDefault();
                                                this.closest('form').submit();"
                                                @if ($user->banned) checked @endif
                                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="red-checkbox"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Banned</label>
                                        </form>
                                        <div class="flex items-center mr-4">

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="py-4 px-6">No hay registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
