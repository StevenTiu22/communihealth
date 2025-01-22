@props([
    'color' => 'gray',
    'darkMode' => true
])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150';

    $colors = [
        'gray' => 'bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 text-white focus:ring-gray-500',
        'blue' => 'bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 text-white focus:ring-blue-500',
        'red' => 'bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800 text-white focus:ring-red-500',
        'green' => 'bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 text-white focus:ring-green-500',
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 text-white focus:ring-yellow-500',
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 text-white focus:ring-indigo-500',
        'purple' => 'bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 text-white focus:ring-purple-500',
    ];

    $darkModeColors = [
        'gray' => 'dark:bg-gray-200 dark:hover:bg-white dark:focus:bg-white dark:active:bg-gray-300 dark:text-gray-800',
        'blue' => 'dark:bg-blue-200 dark:hover:bg-blue-300 dark:focus:bg-blue-300 dark:active:bg-blue-400 dark:text-blue-800',
        'red' => 'dark:bg-red-200 dark:hover:bg-red-300 dark:focus:bg-red-300 dark:active:bg-red-400 dark:text-red-800',
        'green' => 'dark:bg-green-200 dark:hover:bg-green-300 dark:focus:bg-green-300 dark:active:bg-green-400 dark:text-green-800',
        'yellow' => 'dark:bg-yellow-200 dark:hover:bg-yellow-300 dark:focus:bg-yellow-300 dark:active:bg-yellow-400 dark:text-yellow-800',
        'indigo' => 'dark:bg-indigo-200 dark:hover:bg-indigo-300 dark:focus:bg-indigo-300 dark:active:bg-indigo-400 dark:text-indigo-800',
        'purple' => 'dark:bg-purple-200 dark:hover:bg-purple-300 dark:focus:bg-purple-300 dark:active:bg-purple-400 dark:text-purple-800',
    ];

    $colorClasses = $colors[$color] ?? $colors['gray'];
    $darkModeClasses = $darkMode ? ($darkModeColors[$color] ?? $darkModeColors['gray']) : '';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $baseClasses . ' ' . $colorClasses . ' ' . $darkModeClasses]) }}>
    {{ $slot }}
</button>
