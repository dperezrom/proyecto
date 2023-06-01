<x-app-layout>
    @section('title', 'Modificar dirección')
    <div class="flex flex-col items-center py-5">
        <x-slot name="header">
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modificar dirección') }}
            </h1>
        </x-slot>

        <form action="{{ route('direcciones.update', $direccion) }}" method="POST" name="direccion_form">
            @method('PUT')
            <x-direcciones.form :direccion="$direccion"/>
        </form>
    </div>
</x-app-layout>
