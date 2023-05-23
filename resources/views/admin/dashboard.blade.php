<x-app-layout>
    <x-slot name="header" class="mt-40">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-row flex-wrap flex-start justify-center">
        <!-- Categorias -->
        <a href="{{ route('admin.categorias') }}" class="text-4xl">
            <div
                class="text-white flex flex-col justify-center items-center bg-blue-400 hover:bg-blue-500 m-5 p-10 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center">
                    <i class="fa-solid fa-list"></i>
                </div>
                <div class="text-2xl">CATEGORÍAS ({{ $countCategoria }})</div>
            </div>
        </a>

        <!--Productos -->
        <a href="{{ route('admin.productos') }}" class="text-4xl">
            <div
                class="text-white flex flex-col justify-center items-center bg-teal-400 hover:bg-teal-500 m-5 p-10 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="text-2xl">PRODUCTOS ({{ $countProducto }})</div>
            </div>
        </a>

        <!-- Usuarios -->
        <a href="{{ route('admin.users') }}" class="text-4xl">
            <div
                class="text-white flex flex-col justify-center items-center bg-red-400 hover:bg-red-500  m-5 p-10 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="text-2xl">USUARIOS ({{ $countUser }})</div>
            </div>
        </a>
    </div>

</x-app-layout>
