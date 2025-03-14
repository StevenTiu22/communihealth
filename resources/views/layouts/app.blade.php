<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} | CommuniHealth+</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('logo/sjc.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-900">
        <div class="fixed top-0 w-full z-50">
            @include('navigation-menu')
        </div>

        <!-- Main content container -->
        <div class="pt-16">
            <div class="flex relative">
                <div class="fixed left-0 top-16 hidden lg:block">
                    <x-sidebar />
                </div>

                <!-- Main content area -->
                <div id="main-content" class="relative w-full min-h-screen overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-all duration-300 lg:ml-64 overscroll-none">
                    <main class="p-4 sm:p-4 lg:p-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
