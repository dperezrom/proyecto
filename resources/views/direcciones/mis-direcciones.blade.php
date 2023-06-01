<x-app-layout>
    @section('title', 'Mis direcciones')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis direcciones') }}
        </h2>
    </x-slot>
    <!-- Mensaje de éxito/error -->
    <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
        @if (session()->has('success'))
            <div class="p-3 text-green-700 bg-green-300 rounded mb-4 px-5 text-center">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 text-red-700 bg-red-300 rounded mb-4 px-5 text-center">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>

    <!-- Volver -->
    <div class="w-full flex justify-center pt-5">
        <a href="{{ route('dashboard') }}"
            class="bg-emerald-500 hover:bg-emerald-700 text-white focus:ring-2 focus:ring-emerald-300 font-medium rounded-md px-2 py-1">
            <i class="fa-sharp fa-solid fa-arrow-left pr-1"></i>Volver
        </a>
    </div>

    <div class="flex flex-row flex-wrap flex-start justify-center">
        <!-- Botón añadir -->
        <div class="flex flex-col justify-center items-center text-sm bg-white dark:bg-gray-700 dark:text-white m-5 p-5 sm:p-10 text-gray-800 rounded-lg shadow-lg w-full sm:w-80">
            <div class="flex justify-center">
                <a href="{{ route('direcciones.create') }}" class="text-5xl text-teal-500 hover:text-teal-600">
                    <i class="fa-solid fa-square-plus"></i>
                </a>
            </div>
            <div class="text-2xl text-gray-500 dark:text-white">Añadir dirección</div>
        </div>

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

                <div class="flex mt-3 space-x-3 w-full">
                    <a href="#"
                        class="px-4 py-1 text-sm text-white bg-blue-400 hover:bg-blue-500 rounded">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Quieres eliminar la dirección seleccionada?')"
                            class="px-4 py-1 text-sm text-white bg-red-400 hover:bg-red-500  rounded" type="submit"><i
                                class="fa-solid fa-trash"></i></button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
</x-app-layout>
