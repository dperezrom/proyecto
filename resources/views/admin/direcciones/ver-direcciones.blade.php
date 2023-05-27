<x-app-layout>
    @section('title', 'Direcciones - ' . $user->name)

    <!-- Volver -->
    <div class="w-full flex justify-center pt-5">
        <a href="{{ route('admin.users') }}"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>

    <div class="mx-5 text-gray-800 dark:text-white py-3 border-b-2 border-gray-300 break-words">
        <h1 class="text-2xl font-bold text-center">DIRECCIONES DE {{ mb_strtoupper($user->name) }}</h1>
        <h2 class="text-lg text-center">({{ $user->email }})</h2>
    </div>

    @if (count($user->direcciones) < 1)
    <div class="my-4 mx-2 px-6 py-4 bg-gray-800 text-white text-center">
        <span>No se han encontrado resultados.</span>
    </div>
    @else
    <div class="flex flex-row flex-wrap flex-start justify-center">
        <!-- Tarjeta direcciones -->
        @foreach ($user->direcciones as $direccion)
            <div class="text-sm bg-white dark:bg-gray-700 dark:text-white m-5 p-5 sm:p-10 text-gray-800 rounded-lg shadow-lg w-full sm:w-80">
                <!-- Nombre destinatario-->
                <div class="mb-3">
                    <span class="text-lg font-bold mr-2">{{ $direccion->nombre }}</span>
                </div>

                <!-- Ciudad -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Ciudad:</span>
                    <span>{{ $direccion->ciudad }}</span>
                </div>

                <!-- Provincia -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Provincia:</span>
                    <span>{{ $direccion->provincia }}</span>
                    <span>({{ $direccion->cp }})</span>
                </div>

                <!-- Calle -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Calle:</span>
                    <span>{{ $direccion->calle }}</span>
                </div>

                <!-- Teléfono -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Teléfono:</span>
                    <span>{{ $direccion->telefono }}</span>
                </div>

                <!-- Instrucción -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Instrucción:</span>
                    <span>{{ $direccion->instruccion }}</span>
                </div>

                <!-- Fecha creación -->
                <div class="mb-3">
                    <span class="text-gray-500 dark:text-gray-400">Creación:</span>
                    <span>{{ $direccion->created_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</span>
                </div>

                <!-- Fecha modificación -->
                @if ($direccion->created_at != $direccion->updated_at)
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Modificado:</span>
                    <span>{{ $direccion->updated_at->setTimeZone(new DateTimeZone('Europe/Madrid'))->format('d-m-Y H:i:s') }}</span>
                </div>
                @endif

            </div>
        @endforeach
    </div>
    @endif
</x-app-layout>
