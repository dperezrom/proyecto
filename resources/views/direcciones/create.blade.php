<x-app-layout>
    @section('title', 'Crear dirección')
    <div class="flex flex-col items-center py-5">
        <x-slot name="header">
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Añadir dirección') }}
            </h1>
        </x-slot>

        <form action="{{ route('direcciones.store', [], false) }}" method="POST" name="direccion_form">
            <x-direcciones.form :direccion="$direccion"/>
        </form>
    </div>
</x-app-layout>
