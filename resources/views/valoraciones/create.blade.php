<x-app-layout>
    @section('title', 'Crear valoración')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('AÑADIR VALORACIÓN') }}
            </h2>
        </x-slot>
        <form action="{{ route('valoraciones.crear-valoracion', [], false) }}" method="POST" name="valoracion_form">
            <x-valoraciones.form-user :valoracion="$valoracion" :producto="$producto"/>

        </form>
    </div>
</x-app-layout>
