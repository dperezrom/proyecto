<x-app-layout>
    <!-- Volver -->
    <div class="w-full flex justify-center pt-5">
        <a href="{{ route('admin.productos') }}"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>
    <!-- PRODUCTO -->
    <div class="flex flex-col md:flex-row bg-white border m-5 p-3">

        <!-- Imagen -->
        <div class="flex justify-center mb-3">
            <img src="/images/productos/{{ old('imagen', $producto->imagen) ?: 'default.png' }}"
                alt="{{ $producto->denominacion }}"
                class="object-cover w-72 h-72 border-4 border-gray-500/50 bg-gray-800 rounded-lg">
        </div>

        <!-- Datos -->
        <div class="px-10 py-5">
            <div class="mb-3 pb-3 border-b-2 border-gray-300">
                <!-- Título y categoría-->
                <div class="flex items-center flex-wrap">
                    <span class="font-bold text-4xl text-gray-800 mr-2">{{ $producto->denominacion }}</span>
                    @if ($producto->activo == 't')
                        <span class="mr-3 text-green-500 text-lg flex item-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                    @else
                        <span class="mr-3 text-red-500 text-xl flex item-center">
                            <i class="fa-solid fa-circle"></i>
                        </span>
                    @endif
                    <span class="p-1 bg-white border rounded-lg">{{ $producto->categoria->nombre }}</span>

                </div>
            </div>

            <!-- Precio -->
            @php
                $fmt = numfmt_create('es_ES', NumberFormatter::CURRENCY);
            @endphp
            <div class="pb-5 border-b-2 border-gray-300">
                <div>
                    @if ($producto->descuento)
                        <span class="text-red-600 text-xl mr-1">-{{ $producto->descuento }}%</span>
                    @endif
                    <span class="text-2xl font-bold">{{ numfmt_format_currency($fmt, round(($producto->precio * (100 - $producto->descuento)) / 100, 2), 'EUR') }}</span>
                    <span class="text-sm text-gray-500">({{$producto->iva}}% IVA)</span>
                </div>
                @if ($producto->descuento > 0)
                    <div>
                        <span class="text-sm text-gray-500">Precio anterior:</span>
                        <span class="line-through text-gray-800">{{ numfmt_format_currency($fmt, $producto->precio, 'EUR') }}</span>
                    </div>
                @endif
            </div>

            <!-- Stock -->
            <div class="text-gray-800 mb-3 py-3 border-b-2 border-gray-300">
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
                <p>- {{ $producto->descripcion }}</p>
            </div>

            <!-- Actualizado -->
            <div class="text-gray-800">
                <span class="text-sm text-gray-500">Última actualización:</span>
                <p>- {{ $producto->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</p>
            </div>
        </div>


    </div>
</x-app-layout>
