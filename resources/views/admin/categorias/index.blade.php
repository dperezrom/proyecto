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
        <!-- Añadir categoría -->
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Categorías</h1>
            <a href="{{ route('admin.categorias.create') }}"
                class="text-3xl text-emerald-500 hover:text-emerald-600 transition duration-150 ease-in-out">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>

        <!-- Buscador -->
        <div x-data="{ open: localStorage.getItem('menu_filtro') }">
            <div x-on:click="open = (open == 'true') ? 'false':'true'; localStorage.setItem('menu_filtro', open);"
                class="bg-gray-800 text-emerald-400 px-5 py-2 cursor-pointer">
                <button><i class="fa-solid fa-filter pr-2"></i>Filtros</button>
            </div>

            <div x-show="open == 'true'" x-cloak x-transition class="px-5 py-3 text-white bg-gray-700 rounded-b-lg border-b-8 border-gray-900">
                <form action="{{ route('admin.categorias') }}" method="GET">
                    <!-- Orden -->
                    <input type="hidden" name="orden" value="{{ old('orden') }}">

                    <!-- Nombre -->
                    <div class="mb-2">
                        <label for="nombre" class="text-sm font-medium text-gray-100 mr-3 w-20 inline-block">
                            Nombre:
                        </label>

                        <input type="text" name="nombre" id="nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                            value="{{ request()->query('nombre') }}">
                    </div>

                    <!-- Descripción -->
                    <div class="mb-2">
                        <label for="descripcion" class="text-sm font-medium text-gray-100 mr-3 w-20 inline-block">
                            Descripción:
                        </label>
                        <input type="text" name="descripcion" id="descripcion"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80"
                            value="{{ request()->query('descripcion') }}">
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-5">
                        <button type="submit"
                            class="text-white bg-emerald-500 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-md px-2 py-1 text-center"><i
                                class="fa-solid fa-magnifying-glass pr-2"></i>Buscar</button>

                        <button
                            class="bg-gray-400 hover:bg-gray-500 text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md px-2 py-1">
                            <a href="{{ route('admin.categorias') }}"><i class="fa-solid fa-xmark pr-2"></i>Limpiar</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        @if(count($categorias) < 1)
        <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
            <span >No se han encontrado resultados.</span>
        </div>
        @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg sm:mx-5 my-5">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">

                    @php
                        // Filtrado
                        $nombre = request()->get('nombre');
                        $descripcion = request()->get('descripcion');
                        $link = e('nombre=' . $nombre . '&descripcion=' . $descripcion);

                        // Orden
                        $orden = request()->get('orden');
                        $torden = request()->get('torden');
                        $torden = !$torden || $torden == 'ASC' ? 'DESC' : 'ASC';

                        // Iconos orden
                        $estiloAsc = '&#xf15d;';
                        $estiloDesc = '&#xf881;';

                        // Orden columna1
                        $estiloNombre = '';
                        $tOrdenNombre = '';
                        if ($orden == 'nombre') {
                            $estiloNombre = $torden == 'DESC' ? $estiloAsc : $estiloDesc;
                            $tOrdenNombre = '&torden=' . $torden;
                        }

                        // Orden columna2
                        $estiloDescripcion = '';
                        $tOrdenDescripcion = '';
                        if ($orden == 'descripcion') {
                            $estiloDescripcion = $torden == 'DESC' ? $estiloAsc : $estiloDesc;
                            $tOrdenDescripcion = '&torden=' . $torden;
                        }

                    @endphp
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <a href="{{ route('admin.categorias') }}?orden=nombre&{!! $link . $tOrdenNombre !!}" class="flex items-center">
                                <span>Nombre</span>
                                <span class="text-lg"><i class='fas'>{!! $estiloNombre !!}</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <a href="{{ route('admin.categorias') }}?orden=descripcion&{!! $link . $tOrdenDescripcion !!}" class="flex items-center">
                                <span>Descripción</span>
                                <span class="text-lg"><i class='fas'>{!! $estiloDescripcion !!}</i></span>
                            </a>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr
                            class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $categoria->nombre }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $categoria->descripcion }}
                            </td>

                            <td class="px-6 py-4 text-right flex items-center">

                                <div>
                                    <a href="{{ route('admin.categorias.edit', $categoria) }}" class="text-xl text-blue-400"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <span class="px-1 text-gray-400 select-none">|</span>
                                <div>
                                    <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST">
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
                    <tr class="bg-slate-300">
                        <td colspan="4" class="px-6 py-4">
                            {{ $categorias->links('vendor.pagination.tailwind') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>

</x-app-layout>
