<x-app-layout>
    <div class=" bg-gray-200 border-gray-200 shadow rounded-md pb-5">
        <!-- Añadir categoría -->
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
                <h1 class="text-2xl font-semibold px-3 text-gray-800">Categorías</h1>
                <a href="/categorias/create"
                    class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                    <i class="fa-regular fa-square-plus"></i>
                </a>
        </div>

        <!-- Resultados -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg sm:mx-5 my-5">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Nombre
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1"
                                        aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                    </svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Descripción
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1"
                                        aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                    </svg></a>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr
                            class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $categoria->nombre }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $categoria->descripcion }}
                            </td>

                            <td class="px-6 py-4 text-right flex items-center">

                                <div>
                                    <a href="/categorias/{{ $categoria->id }}/edit" class="text-xl text-blue-400"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <span class="px-1 text-gray-400 select-none">|</span>
                                <div>
                                    <form action="/categorias/{{ $categoria->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('¿Quieres eliminar la categoría seleccionada?')"
                                            class="text-xl text-red-400 " type="submit"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-300">
                        <td colspan="4" class="px-6 py-4">
                            {{ $categorias->links('vendor.pagination.tailwind') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
