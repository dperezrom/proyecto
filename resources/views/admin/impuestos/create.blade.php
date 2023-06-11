<x-app-layout>
    @section('title', 'Crear impuesto')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('INSERTAR IMPUESTO') }}
            </h2>
        </x-slot>
        <form action="{{ route('admin.impuestos.store', [], false) }}" method="POST" name="impuesto_form">
            <x-impuestos.form :impuesto="$impuesto"/>

        </form>
    </div>
</x-app-layout>
