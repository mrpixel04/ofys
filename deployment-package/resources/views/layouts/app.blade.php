<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OFYS - Outdoor For Your Soul') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <!-- Using manual asset bundling -->
        <link rel="stylesheet" href="{{ url('/public/css/app.css') }}">

        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col h-full">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('layouts.partials.footer')

        <!-- Scripts - Order matters here -->
        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="{{ url('/public/js/app.js') }}" defer></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Setup alert close functionality
                const alertCloseButton = document.querySelector('.bg-green-100 svg');
                if (alertCloseButton) {
                    alertCloseButton.addEventListener('click', function() {
                        const alert = this.closest('.bg-green-100');
                        alert.classList.add('hidden');
                    });

                    // Auto-hide success message after 5 seconds
                    setTimeout(function() {
                        const alert = document.querySelector('.bg-green-100');
                        if (alert) {
                            alert.classList.add('hidden');
                        }
                    }, 5000);
                }
            });
        </script>
    </body>
</html>
