<x-app-layout>
    @section('title', 'Crear producto')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('INSERTAR PRODUCTO') }}
            </h2>
        </x-slot>
        <form action="{{ route('admin.productos.store', [], false) }}" method="POST" name="producto_form" enctype="multipart/form-data">
            <x-productos.form :producto="$producto" :categorias="$categorias" :impuestos="$impuestos"/>

        </form>
    </div>
</x-app-layout>
