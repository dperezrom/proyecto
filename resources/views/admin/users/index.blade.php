<x-app-layout>
    <!-- Mensaje de éxito -->
    <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
        @if (session()->has('success'))
            <div class="p-3 text-green-700 bg-green-300 rounded mb-4 px-5">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 text-red-700 bg-red-300 rounded mb-4 px-5">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>

    <div class=" bg-gray-200 border-gray-200 shadow rounded-md pb-5 sm:mx-5 lg:mx-20">
        <!-- Añadir usuario -->
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Usuarios</h1>
            <a href="#"
                class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>

        <!-- Resultados -->
        @if (count($users) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
                <span>No se han encontrado resultados.</span>
            </div>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-1 py-5 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <a href="#"
                                    class="flex items-center">
                                    <span>Nombre</span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="#"
                                    class="flex items-center">
                                    <span>Email</span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="#"
                                    class="flex items-center">
                                    <span>Teléfono</span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="#"
                                    class="flex items-center">
                                    <span>Rol</span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user->name }}
                                </th>
                                
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->telefono }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->rol }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <a href="#"
                                                class="text-xl text-blue-400"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        </div>
                                        <span class="px-1 text-gray-400 select-none">|</span>
                                        <div>
                                            <form action="#"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('¿Quieres eliminar el usuario seleccionado?')"
                                                    class="text-xl text-red-400" type="submit">
                                                    <i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="bg-slate-300 px-6 py-4 w-full">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
