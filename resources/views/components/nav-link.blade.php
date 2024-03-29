@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-emerald-400 dark:border-emerald-600 text-sm font-medium leading-5 text-white hover:text-emerald-400 dark:text-gray-100 focus:outline-none focus:border-emerald-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-200 dark:text-gray-400 hover:text-emerald-400 dark:hover:text-emerald-300 hover:border-emerald-300 dark:hover:border-emerald-700 focus:outline-none focus:text-emerald-600 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
