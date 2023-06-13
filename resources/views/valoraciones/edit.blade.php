<x-app-layout>
    @section('title', 'Modificar valoración')
    <div class="flex justify-center mt-4 w-full">
        <x-slot name="header">
            <h1 class="text-2xl font-semibold bg-emerald-800 dark:bg-emerald-500 py-3 px-3 text-white text-center">MODIFICAR VALORACIÓN</h1>
        </x-slot>
        <form action="{{ route('valoraciones.modificar-valoracion', $valoracion) }}" method="POST" name="valoracion_form">
            @method('PUT')
            <x-valoraciones.form-user :valoracion="$valoracion" :producto="$producto"/>

        </form>
    </div>
</x-app-layout>
