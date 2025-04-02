<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OFYS - Outdoor For Your Soul</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white min-h-screen flex flex-col items-center justify-center p-6">
        <div class="max-w-4xl w-full">
            <h1 class="text-3xl font-bold mb-8 text-center">Livewire Test Page</h1>

            <div class="mb-8">
                <livewire:counter />
            </div>

            <div class="text-center">
                <a href="{{ url('/') }}" class="text-blue-500 hover:underline">Back to Home</a>
            </div>
        </div>
    </body>
</html>