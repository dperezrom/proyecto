@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-emerald-400 dark:border-emerald-600 text-left text-base font-medium text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/50 focus:outline-none focus:text-emerald-800 dark:focus:text-emerald-200 focus:bg-emerald-100 dark:focus:bg-emerald-900 focus:border-emerald-700 dark:focus:border-emerald-300 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-100 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-emerald-50 dark:hover:bg-gray-700 hover:border-emerald-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
