<x-app-layout>
    @section('title', 'Crear categoría')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('INSERTAR CATEGORÍA') }}
            </h2>
        </x-slot>
        <form action="{{ route('admin.categorias.store', [], false) }}" method="POST" name="categoria_form">
            <x-categorias.form :categoria="$categoria"/>

        </form>
    </div>
</x-app-layout>
