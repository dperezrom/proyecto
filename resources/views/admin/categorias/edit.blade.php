<x-app-layout>
    @section('title', 'Editar categoría')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold bg-emerald-800 dark:bg-emerald-500 py-3 px-3 text-white text-center">EDITAR CATEGORÍA</h1>
        </x-slot>
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" name="categoria_form">
            @method('PUT')
            <x-categorias.form :categoria="$categoria"/>

        </form>
    </div>
</x-app-layout>
