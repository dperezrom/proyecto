<x-app-layout>
    @section('title', 'Ver producto - ' . $producto->denominacion)
    <div class="w-full sm:flex sm:flex-wrap sm:justify-center mt-16">
        <!-- Volver -->
        <div class="w-full flex justify-center pt-5">
            <a href="/"
               class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
                <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
            </a>
        </div>
        <div class="w-full xl:w-4/5">
            <!-- PRODUCTO -->
            <div class="flex flex-col lg:flex-row bg-white border m-5 p-3">
                <!-- Imagen -->
                <div class="flex justify-center mb-3 w-full lg:w-1/3">
                    <img src="/images/productos/{{ old('imagen', $producto->imagen) ?: 'default.png' }}"
                         alt="{{ $producto->denominacion }}"
                         class="object-cover w-72 h-72 rounded-lg">
                </div>

                <!-- Datos -->
                <div class="px-10 py-5">
                    <!-- Título y categoría-->
                    <div class="mb-3 pb-3 border-b-2 border-gray-300">
                        <div class="flex items-center flex-wrap">
                            <span class="font-bold text-4xl text-gray-800 mr-2">{{ $producto->denominacion }}</span>
                            <span class="p-1 bg-white border rounded-lg">{{ $producto->categoria->nombre }}</span>
                        </div>
                    </div>

                    <!-- Precio -->
                    @php
                        $fmt = numfmt_create('es_ES', NumberFormatter::CURRENCY);
                    @endphp
                    <div class="pb-3 border-b-2 border-gray-300">
                        <div>
                            @if ($producto->descuento)
                                <span class="text-red-600 text-xl mr-1">-{{ $producto->descuento }}%</span>
                            @endif
                            <span class="text-2xl font-bold">
                                {{ numfmt_format_currency($fmt, round(($producto->precio * (100 - $producto->descuento)) / 100, 2), 'EUR') }}
                            </span>
                        </div>
                        @if ($producto->descuento > 0)
                            <div>
                                <span class="text-sm text-gray-500">Precio anterior:</span>
                                <span
                                    class="line-through text-gray-800">{{ numfmt_format_currency($fmt, $producto->precio, 'EUR') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Stock -->
                    <div class="text-gray-800 py-3 border-b-2 border-gray-300">
                        @if ($producto->stock <= 0)
                            <span class="text-red-500 font-bold">Sin existencias</span>
                        @else
                            <span>Stock disponible:</span>
                            <span class="px-1 font-bold bg-white border">{{ $producto->stock }}</span>
                            <span>unidades</span>
                        @endif
                    </div>

                    <!-- Descripción -->
                    <div class="text-gray-800 py-3 border-b-2 border-gray-300">
                        <span class="text-sm text-gray-500">Descripción del producto:</span>
                        <p>{{ $producto->descripcion }}</p>
                    </div>
                </div>

                <!-- Añadir al carrito -->
                <div class="px-10 py-5">
                    <form action="{{ route('carritos.actualizar-carrito') }}" name="insertar_carrito" method="POST" id="insertar_carrito">
                        @csrf
                        @method('PUT')
                        <!-- Stock -->
                        <div>
                            @if($producto->stock > 0)
                                <span class="text-lg font-bold text-green-600">En stock</span>
                            @else
                                <span class="text-lg font-bold text-red-600">Sin stock</span>
                            @endif
                        </div>
                        <input type="hidden" name="modo" id="modo" value="item">
                        <input type="hidden" name="producto_id" id="producto_id" value="{{ $producto->id }}">
                        <!-- Cantidad -->
                        <div class="mb-3 pb-3 flex items-center">
                            <label for="cantidad" class="text-gray-800 mr-1">
                                Cantidad:
                            </label>
                            <select name="cantidad" id="cantidad"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                                @for($i = 1; $i <= $producto->stock; $i++)
                                    <option value={{ $i }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Botón -->
                        <div>
                            <button type="submit" id="insertar_carrito_submit" value=""
                                    class="text-gray-800 bg-yellow-300 hover:bg-yellow-400 focus:ring-2 focus:ring-yellow-300 font-medium rounded-md px-2 py-1 text-center">
                                Añadir al carrito
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Puntuación -->
            <div class="bg-white dark:bg-gray-700 border m-5 p-5">
                <div class="mb-2">
                    <p class="text-lg font-medium text-gray-900 dark:text-white">Valoraciones de los clientes</p>
                </div>
                <div class="flex items-center mb-3">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg aria-hidden="true"
                             class="w-5 h-5 {{ $valoracionMedia >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>{{ $i }} star</title>
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    @endfor
                    <p class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $valoracionMedia }} de 5</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $totalValoraciones }} valoraciones en total</p>
                </div>
                <div>
                    @foreach ($porcentajeValoraciones as $valoracion => $porcentaje)
                        <div class="flex items-center mt-4">
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $valoracion }}
                                estrellas</span>
                            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded">
                                <div class="h-5 bg-yellow-400 rounded" style="width: {{ $porcentaje }}%"></div>
                            </div>
                            <span
                                class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $porcentaje }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Comentarios del producto -->
            <div class="py-5">
                <div class="px-5">
                    <div x-data class="mb-5">
                        <form action="{{ route('productos.ver-producto', $producto) }}" name="orden_form"
                              method="get">
                            <select name="orden" id="orden" @change="orden_form.submit()"
                                    class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-md focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
                                <option value='desc' {{ request()->query('orden') == 'desc' ? 'selected' : '' }}>Más
                                    recientes
                                </option>
                                <option value='asc' {{ request()->query('orden') == 'asc' ? 'selected' : '' }}>Más
                                    antiguas
                                </option>
                            </select>
                        </form>
                    </div>

                    @foreach ($valoraciones as $valoracion)
                        <div class="w-auto bg-white dark:bg-gray-700 border mb-5 p-3 md:p-5 rounded-lg">
                            <article>
                                <div class="flex items-center space-x-4">
                                    <div class="space-y-1 font-medium dark:text-white">
                                        <p class="break-all">
                                            <span class="mr-2">{{ $valoracion->user->name }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg aria-hidden="true"
                                             class="w-5 h-5 {{ $valoracion->puntuacion >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"
                                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <title>{{ $i }} star</title>
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor

                                    <h3 class="ml-2 text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $valoracion->titulo }}
                                    </h3>
                                </div>
                                <div class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                    <p>Comentado
                                        en: {{$valoracion->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</p>
                                    @if ($valoracion->created_at != $valoracion->updated_at)
                                        <p>Última modificación: {{$valoracion->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</p>
                                    @endif
                                </div>
                                <p class="mb-2 font-light text-gray-500 dark:text-white">{{ $valoracion->comentario }}
                                </p>
                            </article>
                        </div>
                    @endforeach
                </div>
                @if (count($valoraciones) == 0)
                    <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white text-center">
                        <span>Aún no hay comentarios para éste producto.</span>
                    </div>
                @endif
                <div class="bg-slate-300 dark:bg-gray-800 sm:mx-5 px-6 py-4">
                    {{ $valoraciones->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
