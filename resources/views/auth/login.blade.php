<x-guest-layout>
    @section('title', 'Login')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="text-white font-bold text-3xl text-center mb-5 py-1 rounded-md
        bg-gradient-to-r from-green-400 to-emerald-600">Iniciar sesión</h1>
        <!-- Email Address -->
        <div>
            <label class="font-bold dark:text-white" for="email"><i class="fa-solid fa-envelope pr-1"></i>Email</label>
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required
                          pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$"
                          autofocus autocomplete="username" maxlength="50"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Contraseña -->
        <div class="mt-4" x-data="{ show: true }">
            <label class="font-bold dark:text-white pr-1 pb-1" for="password" id="label_password">
                <i class="fa-solid fa-lock pr-1"></i>Contraseña
            </label>
            <div class="flex w-full mt-1">
                <input :type="show ? 'password' : 'text'" id="password" name="password" required
                       autocomplete="current-password"
                       class="rounded-none rounded-l-lg  border text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5
                       border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500
                       dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 shadow-sm transition duration-350 focus:ease-in">

                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 cursor-pointer
              border-gray-300 rounded-r-md dark:bg-gray-300 dark:text-gray-400 dark:border-gray-600"
                      @click="show = !show">
                <svg class="h-4 w-4 text-gray-700" fill="none"
                     :class="{'hidden': !show, 'block':show }"
                     xmlns="http://www.w3.org/2000/svg"
                     viewbox="0 0 576 512">
                    <path fill="currentColor"
                          d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                    </path>
                </svg>
                <svg class="h-4 w-4 text-gray-700" fill="none"
                     :class="{'block': !show, 'hidden':show }"
                     xmlns="http://www.w3.org/2000/svg"
                     viewbox="0 0 640 512">
                    <path fill="currentColor"
                          d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                    </path>
                </svg>
              </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                       name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('password.request') }}">
                    {{ __('Olvidé la contraseña') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
