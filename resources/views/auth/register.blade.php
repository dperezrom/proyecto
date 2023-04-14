<x-guest-layout>
    <script type="text/javascript" src="{{ asset('js/register.js')}}" defer></script>

    <form method="POST" action="{{ route('register') }}" >
        @csrf

        <h1 class="text-white font-bold text-3xl text-center mb-5 py-1 rounded-md
        bg-gradient-to-r from-green-400 to-emerald-600">Regístrate</h1>

        <!-- Nombre -->
        <div>
            <label class="font-bold dark:text-white" for="name"><i class="fa-solid fa-user pr-1"></i>Nombre</label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" placeholder="Nombre y apellido" maxlength="35" minlength="2"
                pattern="^((\s?[a-zA-ZáéíóúÁÉÍÓÚñÑ]+){2,4})" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <label class="font-bold dark:text-white"" for="telefono"><i class="fa-solid fa-mobile-screen pr-1"></i>Teléfono</label>
            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"
                required autofocus placeholder="6XXXXXXXX" maxlength="9" pattern="^[1-9]\d{8}$" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <label class="font-bold dark:text-white"" for="email"><i class="fa-solid fa-envelope pr-1"></i>Email</label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="ejemplo@gmail.com" maxlength="50" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <label class="font-bold dark:text-white"" for="password"><i class="fa-solid fa-lock pr-1"></i>Contraseña</label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" placeholder="Al menos 8 carácteres" minlength="8" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <label class="font-bold dark:text-white"" for="password_confirmation"><i class="fa-solid fa-lock pr-1"></i>Confirmar
                contraseña</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <!-- Enlace al login -->
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Iniciar sesión') }}
            </a>

            <!-- Botón registro -->
            <x-primary-button class="ml-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
