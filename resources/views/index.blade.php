<x-app-layout>
    @section('title', 'Inicio')

    <div class="sm:flex">
        <aside class="bg-white dark:bg-gray-700 text-gray-800 dark:text-white w-auto sm:w-1/2 md:w-2/6 lg:w-1/6 px-10 py-5 mt-16">
            <!-- Filtros -->
            <form action="/" name="form_filtro" method="GET" id="form_filtro">
                <!-- Filtro valoraciones -->
                <div x-data class="mb-4">
                    <span class="font-bold">POR VALORACIÓN</span>
                    <ul>
                        <li class="pt-1 flex items-center">
                            <input type="radio" name="stars" value="" id="stars-todo" @change="form_filtro.submit()"
                                   {{ request()->query('stars') == '' ? 'checked' : '' }}
                                   class="mr-2 cursor-pointer w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-400 dark:border-gray-600">
                            <label for="stars-todo" class="text-gray-700 dark:text-white cursor-pointer">Ver
                                todo</label>
                        </li>
                        @for ($i = 4; $i >= 1; $i--)
                            <li class="py-1 flex items-center">
                                <input type="radio" name="stars" id="{{ $i . '-star' }}" value="{{ $i }}"
                                       @change="form_filtro.submit()"
                                       {{ request()->query('stars') == $i ? 'checked' : '' }}
                                       class="mr-1 cursor-pointer w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-400 dark:border-gray-600">
                                @for ($j = 1; $j <= 5; $j++)
                                    <label for="{{ $i . '-star' }}" class="cursor-pointer">
                                        <svg aria-hidden="true"
                                             class="w-5 h-5 {{ $j <= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"
                                             fill="currentColor" viewBox="0 0 20 20"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <title>{{ $i }} star</title>
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </label>
                                @endfor
                            </li>
                        @endfor
                    </ul>
                </div>

                <!-- Filtro precio -->
                <div class="mb-3">
                    <span class="font-bold">POR PRECIO</span>
                    <div class="flex flex-wrap py-2">
                        <input type="text" name="precio_min" id="precio_min" min="0" pattern="^[0-9]+([,\.][0-9]{1,2})?"
                               placeholder="Mín" value="{{ request()->query('precio_min') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-800 rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-16 h-8 my-1 mr-2">
                        <input type="text" name="precio_max" id="precio_max" min="0" pattern="^[0-9]+([,\.][0-9]{1,2})?"
                               placeholder="Máx" value="{{ request()->query('precio_max') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-16 h-8 my-1 mr-2">
                        <button type="submit"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md px-2 focus:ring-2 focus:ring-gray-500 focus:outline-none h-8 my-1">
                            Ir
                        </button>
                    </div>
                </div>

                <!-- Filtro categorías -->
                <div x-data class="mb-3">
                    <span class="font-bold">POR CATEGORÍA</span>
                    <ul>
                        @foreach ($categorias as $categoria)
                            <li class="py-1">
                                <label class="text-gray-700 dark:text-white cursor-pointer flex items-center space-x-1">
                                    <input type="checkbox" name="categoria_seleccionadas[]"
                                           @change="form_filtro.submit()"
                                           {{ in_array($categoria->id, $categoria_seleccionadas) ? 'checked' : ''}}
                                           class="cursor-pointer w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-400 dark:border-gray-600"
                                           value="{{ $categoria->id }}">
                                    <span>{{ $categoria->nombre }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </aside>
        <section class="w-full mt-16">
            <!-- Buscador -->
            <div x-data class="flex px-8 pt-5">
                <div class="relative w-full lg:w-1/2">
                    <label for="producto" class="sr-only">Producto</label>
                    <input type="search" id="producto" name="producto" form="form_filtro"
                           value="{{request()->query('producto')}}"
                           class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg rounded-l-lg border-l border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-emerald-500"
                           placeholder="Busca un producto">
                    <button type="submit" @click="form_filtro.submit()"
                            class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-emerald-700 rounded-r-lg border border-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>

            <!-- Ordenar por precio -->
            <div x-data class="p-5 mx-3">
                <label for="precio_orden" class="sr-only">Ordenar precio</label>
                <select name="precio_orden" id="precio_orden" form="form_filtro" @change="form_filtro.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="asc" {{ request()->query('precio_orden') == 'asc' ? 'selected' : '' }}>
                        Precio: menor a mayor
                    </option>
                    <option value="desc" {{ request()->query('precio_orden') == 'desc' ? 'selected' : '' }}>
                        Precio: mayor a menor
                    </option>
                </select>
            </div>

            <!-- Catálogo -->
            <div class="flex flex-row flex-wrap flex-start w-auto px-5">
                @foreach ($productos as $producto)
                    <div
                        class="bg-white text-gray-800 flex flex-col m-3 p-3 rounded-lg shadow-lg w-full sm:w-80">
                        <a href="{{ route('productos.ver-producto', $producto) }}">
                            <!-- Imagen -->
                            <div class="mb-5">
                                <img
                                    src="/images/productos/{{ old('imagen', $producto->imagen) ?: 'default.png' }}"
                                    alt="{{ $producto->denominacion }}"
                                    class="object-contain w-full h-72 flex justify-center">
                            </div>

                            <!-- Título -->
                            <div class="text-xl">{{ $producto->denominacion }}</div>
                        </a>

                        <!-- Valoraciones producto-->
                        @php
                            $valoraciones = array_column($producto->valoraciones->toArray(), 'puntuacion');
                            $totalValoraciones = count($valoraciones);
                            $valoracionMedia = $totalValoraciones ? array_sum($valoraciones) / $totalValoraciones : 0;
                        @endphp

                        <div class="flex">
                            <span class="mr-2">{{ number_format($valoracionMedia, 1) }}</span>
                            @for ($i = 1; $i <= 5; $i++)
                                <svg aria-hidden="true"
                                     class="w-5 h-5 {{ $valoracionMedia >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"
                                     fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <title>{{ $i }} star</title>
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                            <span class="text-teal-600">({{ $totalValoraciones }})</span>
                        </div>

                        <!-- Precio -->
                        @php
                            $fmt = numfmt_create('es_ES', NumberFormatter::CURRENCY);
                            $precioFinal = numfmt_format_currency($fmt, ($producto->precio * (100 - $producto->descuento)) / 100, 'EUR');
                            $precioAntiguo = numfmt_format_currency($fmt, $producto->precio, 'EUR');
                        @endphp

                        @if ($producto->descuento > 0)
                            <div class="mt-3">
                    <span class="text-sm bg-red-700 text-white p-1 rounded">Ahorra un
                        {{ $producto->descuento }}%</span>
                            </div>
                        @endif
                        <div class="mt-3">
                            <span class="text-2xl font-bold">{{ $precioFinal }}</span>
                            @if ($producto->descuento > 0)
                                <span>Antes a</span>
                                <span class="line-through">{{ $precioAntiguo }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if(count($productos) == 0)
                    <div class="my-4 mx-2 px-6 py-4 bg-slate-500 dark:bg-gray-800 text-white">
                        <span>No se han encontrado resultados.</span>
                    </div>
                @endif
                <div class="bg-slate-300 dark:bg-gray-800 px-6 my-5 py-4 w-full">
                    {{ $productos->links('vendor.pagination.tailwind') }}
                </div>
            </div>

        </section>
    </div>

</x-app-layout>

