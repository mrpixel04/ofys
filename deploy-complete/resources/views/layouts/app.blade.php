<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>{{ config('app.name', 'OFYS - Outdoor For Your Soul') }}</title>

        <!-- Disable Alpine.js completely before anything else loads -->
        <script src="{{ asset('disable-alpine.js') }}"></script>

        <!-- Include jQuery before all other scripts -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            // Ensure jQuery is really loaded
            if (typeof jQuery !== 'undefined') {
                console.log('jQuery is loaded directly in the head');
            }
        </script>

        <style>
            .hidden { display: none !important; }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if(app()->environment('local'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link href="{{ vite_asset('resources/css/app.css') }}" rel="stylesheet">
            <script src="{{ vite_asset('resources/js/app.js') }}" defer></script>
        @endif
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('layouts.partials.footer')

        <!-- Custom Livewire Scripts (without Alpine) -->
        <script src="{{ asset('vendor/livewire/livewire.js') }}" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Block Alpine initialization that might come from Livewire
                if (!window.Alpine) {
                    window.Alpine = {
                        version: 'disabled',
                        start: function() {
                            console.log('Alpine initialization prevented in Livewire script');
                            return this;
                        },
                        plugin: function() {
                            console.log('Alpine plugin loading prevented in Livewire script');
                            return this;
                        }
                    };
                }
            });
        </script>

        <!-- Initialize jQuery elements after Livewire is loaded -->
        <script>
            $(document).ready(function() {
                console.log('Document ready - initializing jQuery in app.blade.php');

                // Handle language dropdown
                $('.lang-dropdown-trigger').on('click', function(e) {
                    e.stopPropagation();
                    $('.lang-dropdown-content').toggleClass('hidden');
                });

                // Handle user dropdown
                $('.user-dropdown-trigger').on('click', function(e) {
                    e.stopPropagation();
                    $('.user-dropdown-content').toggleClass('hidden');
                });

                // Close dropdowns when clicking outside
                $(document).on('click', function() {
                    $('.lang-dropdown-content, .user-dropdown-content').addClass('hidden');
                });

                // Mobile menu toggle
                $('.mobile-menu-button').on('click', function() {
                    $('.mobile-menu').toggleClass('hidden');
                    $('.mobile-menu-icon-open').toggleClass('hidden');
                    $('.mobile-menu-icon-close').toggleClass('hidden');
                });
            });
        </script>
    </body>
</html>
