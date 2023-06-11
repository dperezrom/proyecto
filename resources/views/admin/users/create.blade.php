<x-app-layout>
    @section('title', 'Crear usuario')
    <div class="flex flex-col items-center mt-4 w-full">
        <x-slot name="header" class="mt-40">
            <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('INSERTAR USUARIO') }}
            </h2>
        </x-slot>
        <form action="{{ route('admin.users.store', [], false) }}" method="POST" name="user_form" enctype="multipart/form-data">
            <x-users.form :user="$user"/>

        </form>
    </div>
</x-app-layout>
