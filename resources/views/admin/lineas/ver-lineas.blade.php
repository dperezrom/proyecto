<x-app-layout>
    @section('title', 'Detalle Factura - ' . $factura->id)
    <!-- Volver -->
    <div class="flex justify-center mt-16 py-5">
        <a href="{{ route('admin.facturas.ver-facturas', $factura->user_id) }}"
           class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>

    <div class=" bg-gray-200 border-gray-200 shadow rounded-md pb-5 sm:mx-5 lg:mx-20">
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Factura - {{ $factura->id }}</h1>
        </div>

        <div
            class="text-sm bg-white dark:bg-gray-700 dark:text-white m-2 sm:m-6 p-5 text-gray-800 rounded-lg shadow-lg w-auto sm:w-96 break-words">
            <h3 class="font-bold text-xl mb-1">Dirección de envío:</h3>
            <p class="mb-1"><span class="text-gray-500 dark:text-gray-400">Nombre: </span> {{ $factura->nombre }}</p>
            <p class="mb-1"><span class="text-gray-500 dark:text-gray-400">Calle: </span> {{ $factura->calle }}</p>
            <p class="mb-1"><span class="text-gray-500 dark:text-gray-400">Ciudad: </span> {{ $factura->ciudad }}</p>
            <p class="mb-1"><span
                    class="text-gray-500 dark:text-gray-400">Instrucción: </span> {{ $factura->instruccion }}</p>
            <p><span
                    class="text-gray-500 dark:text-gray-400">Fecha factura: </span>{{ $factura->fecha->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
            </p>
        </div>

        <!-- Desglose factura -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <span>Denominación</span>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span>Cantidad</span>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span>P. Unitario (IVA excluido)</span>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span>IVA</span>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span>P. Unitario (IVA incluido)</span>
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span>Precio Total</span>
                    </th>

                </tr>
                </thead>
                <tbody>
                @php
                    $total = 0;
                    foreach ($factura->lineas as $linea) {
                        $total += $linea->cantidad * $linea->precio * ((100 - $linea->descuento) / 100);
                    }
                @endphp
                @foreach ($factura->lineas as $linea)
                    @php
                        $precio_sin_iva = $linea->precio * ((100 - $linea->iva) / 100) * ((100 - $linea->descuento) / 100);
                        $precio_con_iva = $linea->precio * ((100 - $linea->descuento) / 100);
                        $precio_total_producto = $linea->cantidad * $linea->precio * ((100 - $linea->descuento) / 100);
                    @endphp
                    <tr class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $linea->producto->denominacion }}
                        </th>

                        <td class="px-6 py-4">
                            {{ $linea->cantidad }}
                        </td>

                        <td class="px-6 py-4">
                            {{ number_format($precio_sin_iva, 2, ',')}}€
                        </td>

                        <td class="px-6 py-4">
                            {{ $linea->iva }}%
                        </td>

                        <td class="px-6 py-4">
                            {{ number_format($precio_con_iva, 2, ',')}}€
                        </td>

                        <td class="px-6 py-4">
                            {{ number_format($precio_total_producto, 2, ',')}}€
                        </td>

                    </tr>
                @endforeach
                <tr class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                    <td class="px-6 py-4 text-gray-800 dark:text-white font-bold" colspan="5">TOTAL</td>
                    <td class="px-6 py-4 dark:text-white font-bold">
                        {{ number_format($total, 2, ',') }}€
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
