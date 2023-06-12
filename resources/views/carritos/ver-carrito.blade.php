<x-app-layout>
    <script type="text/javascript" src="{{ asset('js/carritos/ver-carrito.js')}}" defer></script>
    @section('title', 'Ver carrito')
    <!-- Mensaje redirect -->
    <x-mensaje/>

    <x-slot name="header" class="mt-40">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('VER CARRITO') }}
        </h2>
    </x-slot>

    @php
        $fmt = numfmt_create('es_ES', NumberFormatter::CURRENCY);
        $importeTotal = 0;
    @endphp

        <!-- Volver -->
    <div class="w-full flex justify-center pt-5">
        <a href="/"
           class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>



    <div class="mt-16">
        @if(!empty(session()->get('cart_item')))
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="px-6 w-40">Imagen</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Denominación</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Precio/unidad</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>IVA</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Cantidad</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Descuento</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Total</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach (session()->get('cart_item') as $item)
                        @php
                            $importeTotal += $item['total'];
                        @endphp
                        <tr class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <td class="px-6 py-4">
                                <img src="/images/productos/{{ old('imagen', $item['imagen'] ?: 'default.png') }}"
                                     alt="{{ $item['denominacion'] }}" class="object-contain h-28 w-28">
                            </td>

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $item['denominacion'] }}
                            </th>

                            <td class="px-6 py-4">
                                {{ numfmt_format_currency($fmt, $item['precio'], 'EUR') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item['iva'] }}%
                            </td>

                            <td class="px-6 py-4">
                                <div x-data>
                                    <form action="{{ route('carritos.actualizar-carrito') }}"
                                          name="carrito_form_{{ $item['productoId'] }}" method="POST"
                                          id="carrito_form_{{ $item['productoId'] }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="producto_id" id="producto_id"
                                               value="{{ $item['productoId'] }}">

                                        <label class="sr-only" for="cantidad">Cantidad</label>
                                        <input type="hidden" name="modo" id="modo" value="cantidad">
                                        <input type="number" name="cantidad" id="cantidad"
                                               value="{{ $item['cantidad'] }}"
                                               min="1" max="{{ $item['stock'] }}" maxlength="3" minlength="1"
                                               @change="carrito_form_{{$item['productoId']}}.submit()"
                                               @keyup="carrito_form_{{$item['productoId']}}.submit()">
                                    </form>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $item['descuento'] }}%
                            </td>

                            <td class="px-6 py-4">
                                {{ numfmt_format_currency($fmt, $item['total'], 'EUR') }}
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <form action="{{ route('carritos.borrar-item-carrito') }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="producto_id" id="producto_id"
                                               value="{{ $item['productoId'] }}">
                                        <input type="hidden" name="modo" id="modo" value="item">
                                        <button
                                            onclick="return confirm('¿Quieres eliminar el producto seleccionado?')"
                                            class="text-xl text-red-400" type="submit">
                                            <i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    <tr class="bg-gray-800 text-white">
                        <td colspan="5" class="px-6 py-4 font-bold text-lg text-center" >
                            CANTIDAD ARTÍCULOS: {{ session()->get('cart_item_total') }}
                        </td>

                        <td  colspan="2" class="px-6 py-4 font-bold text-lg text-center">
                            IMPORTE TOTAL: {{ numfmt_format_currency($fmt, $importeTotal, 'EUR') }}
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('carritos.borrar-item-carrito') }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="modo" id="modo" value="all">
                                <button
                                    onclick="return confirm('¿Quieres vaciar el carrito?')"
                                    class="text-xl text-red-400" type="submit">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="bg-gray-800 text-white">
                        <td colspan="8" class="px-6 py-4 font-bold text-lg text-right" >
                            <!-- Tramitar pedido -->
                            <a href="/"
                               class="bg-yellow-500 hover:bg-yellow-700 text-white focus:ring-2 focus:ring-yellow-300 font-medium rounded-md px-2 py-1">
                                <i class="fa-brands fa-paypal pr-1"></i>Pagar ({{ numfmt_format_currency($fmt, $importeTotal, 'EUR') }})
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        @else
            <div class="my-4 mx-2 px-6 py-4 bg-slate-500 dark:bg-gray-800 text-white text-center">
                <span>El carrito está vacio.</span>
            </div>
        @endif
    </div>
</x-app-layout>
