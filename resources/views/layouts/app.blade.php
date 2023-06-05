<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Doñana Shop
            @hasSection('title')
                - @yield('title')
            @endif
        </title>

        <!-- CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 dark:bg-gray-900">

            @includeWhen(!Auth::check(),'layouts.guest-navigation')
            @includeWhen(Auth::check() && Auth::user()->rol != 'admin','layouts.navigation')
            @includeWhen(Auth::check() && Auth::user()->rol == 'admin','layouts.admin-navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow {{ (Auth::check() && Auth::user()->rol == 'admin') ? 'sm:ml-64 mt-4 sm:mt-16' : '' }}">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="{{ (Auth::check() && Auth::user()->rol == 'admin') ? 'sm:ml-64 mt-4 sm:mt-16' : '' }}">
                {{ $slot }}
            </main>
        </div>
        <!-- Footer -->
        @include('layouts.footer')
    </body>
</html>
