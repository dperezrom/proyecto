<x-app-layout>
    @section('title', 'Ver usuario - ' . $user->name)
    <div class="w-full flex flex-wrap justify-center">
        <!-- Volver -->
        <div class="w-full flex justify-center pt-5">
            <a href="{{ route('admin.users') }}"
                class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
                <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
            </a>
        </div>
        <!-- Usuario -->
        <div class="flex flex-col md:flex-row flex-wrap bg-white border m-5 p-3 flex-inline lg:w-2/3">
            <!-- Datos -->
            <div class="px-10 py-5">
                <div class="pb-3 border-b-2 border-gray-300">
                    <!-- Nombre y rol -->
                    <div class="flex space-x-4 items-center flex-wrap">
                        <span class="font-bold text-4xl text-gray-800">{{ $user->name }}</span>
                        <span class="text-sm text-gray-500">({{ $user->email }})</span>
                        <span class="p-1 bg-white border rounded-lg">{{ $user->rol }}</span>
                    </div>
                </div>

                <!-- DNI/NIE -->
                <div class="text-gray-800 py-2 border-b-2 border-gray-300">
                    <span class="text-sm text-gray-500">DNI/NIE:</span>
                    <p>{{ $user->documento }}</p>
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="text-gray-800 py-2 border-b-2 border-gray-300">
                    <span class="text-sm text-gray-500">Fecha de nacimiento:</span>
                    <p>{{ $user->fecha_nac->format('d-m-Y') }}</p>
                </div>

                <!-- Teléfono -->
                <div class="text-gray-800 py-2 border-b-2 border-gray-300">
                    <span class="text-sm text-gray-500">Teléfono:</span>
                    <p>{{ $user->telefono }}</p>
                </div>

                <!-- Creado -->
                <div class="text-gray-800 py-2 border-b-2 border-gray-300">
                    <span class="text-sm text-gray-500">Fecha de creación:</span>
                    <p>{{ $user->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
                    </p>
                </div>

                <!-- Actualizado -->
                <div class="text-gray-800 py-2 ">
                    <span class="text-sm text-gray-500">Última actualización:</span>
                    <p>{{ $user->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}
                    </p>
                </div>
            </div>

            <!-- Otros datos -->
            <div class="px-10 py-5">
                <div class="pb-3 border-b-2 border-gray-300">
                    <h2 class="font-bold text-4xl text-gray-800">Otros datos</h2>
                </div>
                <div class="text-gray-800 py-2">
                    <span class="text-sm text-gray-500">Valoraciones realizadas:</span>
                    <span>({{ $user->valoraciones->count() }})</span>
                </div>
                <div class="text-gray-800 py-2">
                    <span class="text-sm text-gray-500">Compras realizadas:</span>
                    <span>({{ $user->facturas->count() }})</span>
                </div>
                <div class="text-gray-800 py-2">
                    <span class="text-sm text-gray-500">Direcciones creadas:</span>
                    <span>({{ $user->direcciones->count() }})</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
