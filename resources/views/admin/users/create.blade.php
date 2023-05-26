<x-app-layout>
    @section('title', 'Crear usuario')
    <div class="flex flex-col items-center mt-4 w-full">
    <x-slot name="header">
        <h1 class="text-2xl font-semibold bg-emerald-800 dark:bg-emerald-500 py-3 px-3 text-white text-center">INSERTAR USUARIO</h1>
    </x-slot>
        <form action="{{ route('admin.users.store', [], false) }}" method="POST" name="user_form" enctype="multipart/form-data">
            <x-users.form :user="$user"/>

        </form>
    </div>
</x-app-layout>
