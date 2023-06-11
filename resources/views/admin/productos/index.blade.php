<x-app-layout>
    @section('title', 'Productos')
    <!-- Mensaje redirect -->
    <x-mensaje/>

    <div class="bg-gray-200 border-gray-200 shadow rounded-md sm:mx-5 lg:mx-20 mt-16 mb-5 pb-1">
        <!-- Añadir producto -->
        <div class="flex items-center justify-center xl:justify-start bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Productos</h1>
            <a href="{{ route('admin.productos.create') }}"
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

            <div x-show="open == 'true'" x-cloak x-transition
                class="px-5 py-3 text-white bg-gray-700 rounded-b-lg border-b-8 border-gray-900">
                <form action="{{ route('admin.productos') }}" method="GET">

                    <!-- Orden -->
                    <input type="hidden" name="orden" value="{{ old('orden') }}">

                    <div class="flex flex-wrap flex-row">
                        <!-- Denopminación -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="denominacion" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Denominación:
                            </label>

                            <input type="text" name="denominacion" id="denominacion"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full flex-auto"
                                value="{{ request()->query('denominacion') }}">
                        </div>

                        <!-- Descripción -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="descripcion" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Descripción:
                            </label>

                            <input type="text" name="descripcion" id="descripcion"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full flex-auto"
                                value="{{ request()->query('descripcion') }}">
                        </div>

                        <!-- Categoría -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="categoria_id" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Categoría:
                            </label>

                            <select name="categoria_id" id="categoria_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full">
                                <option value='' {{ request()->query('categoria_id') == '' ? 'selected' : '' }}>-
                                </option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ request()->query('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Activo -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="activo" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                Activo:
                            </label>

                            <select name="activo" id="activo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full">
                                <option value='' {{ request()->query('activo') == '' ? 'selected' : '' }}>-
                                </option>
                                <option value='t' {{ request()->query('activo') == 't' ? 'selected' : '' }}>Sí
                                </option>
                                <option value='f' {{ request()->query('activo') == 'f' ? 'selected' : '' }}>No
                                </option>
                            </select>

                        </div>

                        <!-- Precio -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="precio"
                                class="text-sm font-medium text-gray-100 mr-3 w-24 sm:w-full inline-block">
                                Precio:
                            </label>

                            <select name="precio_signo" id="precio_signo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-20">
                                <option value='=' {{ request()->query('precio_signo') == '=' ? 'selected' : '' }}>
                                    =</option>
                                <option value='>' {{ request()->query('precio_signo') == '>' ? 'selected' : '' }}>
                                    &gt;</option>
                                <option value='<' {{ request()->query('precio_signo') == '<' ? 'selected' : '' }}>
                                    &lt;</option>
                                <option value='>='
                                    {{ request()->query('precio_signo') == '>=' ? 'selected' : '' }}>&gt;=</option>
                                <option value='<='
                                    {{ request()->query('precio_signo') == '<=' ? 'selected' : '' }}>&lt;=</option>
                            </select>

                            <input type="number" name="precio" id="precio" step="any" min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-24 flex-auto"
                                value="{{ request()->query('precio') }}">
                        </div>

                        <!-- IVA -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="impuesto_id" class="text-sm font-medium text-gray-100 mr-3 w-24">
                                IVA:
                            </label>

                            <select name="impuesto_id" id="impuesto_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-full">
                                <option value='' {{ request()->query('impuesto_id') == '' ? 'selected' : '' }}>-</option>
                                @foreach ($impuestos as $impuesto)
                                    <option value="{{ $impuesto->id }}"
                                        {{ request()->query('impuesto_id') == $impuesto->id ? 'selected' : '' }}>
                                        {{ $impuesto->porcentaje . '% - ' . $impuesto->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!--  Stock -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="stock"
                                class="text-sm font-medium text-gray-100 mr-3 w-24 sm:w-full inline-block">
                                Stock:
                            </label>
                            <select name="stock_signo" id="stock_signo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-20">
                                <option value='=' {{ request()->query('stock_signo') == '=' ? 'selected' : '' }}>=
                                </option>
                                <option value='>' {{ request()->query('stock_signo') == '>' ? 'selected' : '' }}>
                                    &gt;</option>
                                <option value='<' {{ request()->query('stock_signo') == '<' ? 'selected' : '' }}>
                                    &lt;</option>
                                <option value='>=' {{ request()->query('stock_signo') == '>=' ? 'selected' : '' }}>
                                    &gt;=</option>
                                <option value='<=' {{ request()->query('stock_signo') == '<=' ? 'selected' : '' }}>
                                    &lt;=</option>
                            </select>
                            <input type="number" name="stock" id="stock" min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-24 flex-auto"
                                value="{{ request()->query('stock') }}">
                        </div>

                        <!-- Descuento -->
                        <div class="mb-2 w-full sm:w-1/2 sm:px-2 lg:w-1/4">
                            <label for="descuento"
                                class="text-sm font-medium text-gray-100 mr-3 w-24 sm:w-full inline-block">
                                Descuento:
                            </label>

                            <select name="descuento_signo" id="descuento_signo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-20">
                                <option value='='
                                    {{ request()->query('descuento_signo') == '=' ? 'selected' : '' }}>=</option>
                                <option value='>'
                                    {{ request()->query('descuento_signo') == '>' ? 'selected' : '' }}>&gt;</option>
                                <option value='<'
                                    {{ request()->query('descuento_signo') == '<' ? 'selected' : '' }}>&lt;</option>
                                <option value='>='
                                    {{ request()->query('descuento_signo') == '>=' ? 'selected' : '' }}>&gt;=</option>
                                <option value='<='
                                    {{ request()->query('descuento_signo') == '<=' ? 'selected' : '' }}>&lt;=</option>
                            </select>
                            <input type="number" name="descuento" id="descuento" step="any" min="0"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 w-24 flex-auto"
                                value="{{ request()->query('descuento') }}">
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-5">
                        <button type="submit"
                            class="text-white bg-emerald-500 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-medium rounded-md px-2 py-1 text-center"><i
                                class="fa-solid fa-magnifying-glass pr-2"></i>Buscar</button>

                        <button
                            class="bg-gray-400 hover:bg-gray-500 text-white focus:ring-4 focus:ring-gray-300 font-medium rounded-md px-2 py-1">
                            <a href="{{ route('admin.productos') }}"><i
                                    class="fa-solid fa-xmark pr-2"></i>Limpiar</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        @if (count($productos) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
                <span>No se han encontrado resultados.</span>
            </div>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                        @php
                            // Filtrado campos
                            $link = '';
                            foreach ($campos as $campo) {
                                $link .= '&' . $campo . '=' . urlencode(request()->get($campo));
                            }

                            // Orden
                            $orden = request()->get('orden');
                            $torden = request()->get('torden');
                            $torden = !$torden || $torden == 'ASC' ? 'DESC' : 'ASC';

                            // Iconos orden
                            $estiloAsc = '&#xf15d;';
                            $estiloDesc = '&#xf881;';

                            // Iconos orden numérico
                            $estiloAscNum = '&#xf162;';
                            $estiloDescNum = '&#xf163;';

                            // Orden campos
                            foreach ($campos as $campo) {
                                ${'estilo' . ucfirst($campo)} = '';
                                ${'tOrden' . ucfirst($campo)} = '';

                                if ($orden == $campo) {
                                    ${'estilo' . ucfirst($campo)} = $torden == 'DESC' ? $estiloAsc : $estiloDesc;
                                    ${'tOrden' . ucfirst($campo)} = '&torden=' . $torden;
                                }
                            }

                        @endphp
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <span class="px-6 w-40">Imagen</span>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.productos') }}?orden=denominacion{!! $tOrdenDenominacion . $link !!}"
                                    class="flex items-center">
                                    <span>Denominación</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloDenominacion !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.productos') }}?orden=descripcion{!! $tOrdenDescripcion . $link !!}"
                                    class="flex items-center">
                                    <span>Descripción</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloDescripcion !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.productos') }}?orden=categoria_id{!! $tOrdenCategoria_id . $link !!}"
                                    class="flex items-center">
                                    <span>Categoría</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloCategoria_id !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <a href="{{ route('admin.productos') }}?orden=precio{!! $tOrdenPrecio . $link !!}"
                                    class="flex items-center">
                                    <span>Precio</span>
                                    <span class="text-lg"><i class='fas'>{!! $estiloPrecio !!}</i></span>
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span>IVA</span>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span>Stock</span>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span>Activo</span>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <span>Descuento</span>
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
                                <td class="px-6 py-4">
                                    <img src="/images/productos/{{ old('imagen', $producto->imagen) ?: 'default.png' }}"
                                        alt="{{ $producto->denominacion }}" class="object-contain h-28 w-28">
                                </td>

                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('admin.productos.show', $producto) }}">{{ $producto->denominacion }}</a>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $producto->descripcion }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $producto->categoria->nombre }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $producto->precio . '€' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $producto->impuesto->porcentaje . '%' }}
                                </td>

                                <td class="px-6 py-4 {{ $producto->stock < 1 ? 'text-red-500' : '' }}">
                                    {{ $producto->stock }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($producto->activo == 't')
                                        <i class="fa-solid fa-circle text-green-500 text-lg"></i>
                                    @else
                                        <i class="fa-solid fa-circle text-red-500 text-lg"></i>
                                    @endif

                                </td>

                                <td class="px-6 py-4">
                                    {{ $producto->descuento . '%' }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <a href="{{ route('admin.valoraciones.ver-valoraciones', $producto) }}"
                                                class="text-xl text-green-400">
                                                <i class="fa-solid fa-comment"></i>
                                        </div>
                                        <span class="px-1 text-gray-400 select-none">|</span>
                                        <div>
                                            <a href="{{ route('admin.productos.edit', $producto) }}"
                                                class="text-xl text-blue-400"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        </div>
                                        <span class="px-1 text-gray-400 select-none">|</span>
                                        <div>
                                            <form action="{{ route('admin.productos.destroy', $producto) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('¿Quieres eliminar el producto seleccionado?')"
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
            <div class="bg-slate-300 dark:bg-gray-800 px-6 py-4 w-full">
                {{ $productos->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
