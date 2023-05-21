<x-app-layout>
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold bg-emerald-800 dark:bg-emerald-500 py-3 px-3 text-white text-center">EDITAR PRODUCTO</h1>
        </x-slot>
        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" name="producto_form" enctype="multipart/form-data">
            @method('PUT')
            <x-productos.form :producto="$producto" :categorias="$categorias"/>

        </form>
    </div>
</x-app-layout>
