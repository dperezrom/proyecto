<x-app-layout>
    @section('title', 'Mis compras  - ' . $user->name)
    <!-- Volver -->
    <div class="flex justify-center mt-16 py-5">
        <a href="{{ route('catalogo') }}"
           class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>

    <div class="bg-gray-200 border-gray-200 shadow rounded-md pb-5 mb-5 sm:mx-5 lg:mx-20">
        <div class="flex items-center bg-white border-b-4 border-emerald-400 py-3">
            <h1 class="text-2xl font-semibold px-3 text-gray-800">Facturas - {{ $user->name }}</h1>
        </div>
        <!-- Resultados -->
        @if (count($user->facturas) < 1)
            <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white">
                <span>No se han encontrado resultados.</span>
            </div>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-1 sm:mx-5 my-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-separate">
                    <thead class="text-xs text-white uppercase bg-emerald-950 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span>Número</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Fecha</span>
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span>Total</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($paginador as $factura)
                        <tr class="odd:bg-white even:bg-slate-100 border-b dark:even:bg-gray-900 dark:odd:bg-gray-800 dark:border-gray-700 hover:bg-emerald-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <th scope="row"
                                class="px-6 py-4 text-gray-900 whitespace-nowrap font-bold dark:text-white">
                                <a href="#">{{ $factura->numero }}</a>
                            </th>
                            <td class="px-6 py-4">

                                {{ $factura->fecha->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $fmt = numfmt_create('es_ES', NumberFormatter::CURRENCY);
                                        $total = 0;
                                        foreach ($factura->lineas as $linea) {
                                            $total += $linea->cantidad * $linea->precio * ((100 - $linea->descuento) / 100);
                                        }
                                @endphp
                                {{ numfmt_format_currency($fmt, $total, 'EUR') }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-slate-300 dark:bg-gray-800 sm:mx-5 px-6 py-4">
                {{ $paginador->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
