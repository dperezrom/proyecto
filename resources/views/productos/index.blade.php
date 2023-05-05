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
        <!-- Añadir producto -->
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Productos</h1>
            <a href="/productos/create"
                class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>

        <!-- Resultados -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-1 sm:mx-5 my-5">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Denominación</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Descripción</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Precio</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>IVA</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Stock</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Activo</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Descuento</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="#" class="flex items-center">
                                <span>Categoría</span>
                                <span class="text-lg"><i class='fas'>&#xf15d;</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr
                            class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $producto->denominacion }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $producto->descripcion }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $producto->precio . '€' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $producto->iva . '%' }}
                            </td>

                            <td class="px-6 py-4 {{ $producto->stock < 1 ? 'text-red-500' : '' }}">
                                {{ $producto->stock }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($producto->activo)
                                    <i class="fa-solid fa-circle text-green-500 text-lg"></i>
                                @else
                                    <i class="fa-solid fa-circle text-red-500 text-lg"></i>
                                @endif

                            </td>

                            <td class="px-6 py-4">
                                {{ $producto->descuento }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $producto->categoria->nombre }}
                            </td>

                            <td class="px-6 py-4 text-right flex items-center">

                                <div>
                                    <a href="/productos/{{ $producto->id }}/edit" class="text-xl text-blue-400"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <span class="px-1 text-gray-400 select-none">|</span>
                                <div>
                                    <form action="/productos/{{ $producto->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('¿Quieres eliminar la categoría seleccionada?')"
                                            class="text-xl text-red-400" type="submit">
                                            <i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="bg-slate-300 px-6 py-4 w-full">
            {{ $productos->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</x-app-layout>
