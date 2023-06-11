<x-app-layout>
    @section('title', 'Admin Dashboard')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center xl:text-left text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex text-white flex-col sm:flex-row p-10 text-center flex-wrap justify-center">
        <!-- Categorias -->
        <a href="{{ route('admin.categorias') }}">
            <div class="flex flex-col justify-center items-center my-3 sm:mx-3 py-3 bg-blue-400 hover:bg-blue-500 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center text-4xl">
                    <i class="fa-solid fa-list"></i>
                </div>
                <div class="text-2xl">CATEGORÍAS ({{ $countCategoria }})</div>
            </div>
        </a>


        <!--Productos -->
        <a href="{{ route('admin.productos') }}">
            <div class="flex flex-col justify-center items-center my-3 sm:mx-3 py-3 bg-teal-400 hover:bg-teal-500 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center text-4xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="text-2xl">PRODUCTOS ({{ $countProducto }})</div>
            </div>
        </a>

        <!-- Usuarios -->
        <a href="{{ route('admin.users') }}">
            <div class="flex flex-col justify-center items-center my-3 sm:mx-3 py-3 bg-red-400 hover:bg-red-500 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center text-4xl">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="text-2xl">USUARIOS ({{ $countUser }})</div>
            </div>
        </a>

        <!-- Impuestos -->
        <a href="{{ route('admin.impuestos') }}">
            <div class="flex flex-col justify-center items-center my-3 sm:mx-3 py-3 bg-yellow-400 hover:bg-yellow-500 rounded-lg shadow-lg w-full sm:w-80">
                <div class="flex justify-center text-4xl">
                    <i class="fa-solid fa-list-ol"></i>
                </div>
                <div class="text-2xl">IMPUESTOS ({{ $countImpuesto }})</div>
            </div>
        </a>
    </div>

</x-app-layout>
