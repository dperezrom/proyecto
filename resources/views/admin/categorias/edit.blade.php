<x-app-layout>
    @section('title', 'Editar categoría')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('EDITAR CATEGORÍA') }}
            </h2>
        </x-slot>
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" name="categoria_form">
            @method('PUT')
            <x-categorias.form :categoria="$categoria"/>

        </form>
    </div>
</x-app-layout>
