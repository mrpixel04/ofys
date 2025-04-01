<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - OFYS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    <style>
        .bg-image-animation {
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(1.05);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .back-button {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 10;
            transition: transform 0.2s;
        }

        .back-button:hover {
            transform: translateX(-3px);
        }

        .floating-back-button {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 50;
            background-color: rgba(245, 158, 11, 0.9);
            color: white;
            border-radius: 9999px;
            padding: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, background-color 0.2s;
            display: none;
        }

        .floating-back-button:hover {
            transform: scale(1.05);
            background-color: rgba(217, 119, 6, 0.9);
        }

        @media (max-width: 768px) {
            .back-button {
                display: none;
            }

            .floating-back-button {
                display: flex;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Back to Home Button -->
    <a href="{{ url('/') }}" class="back-button flex items-center text-gray-700 hover:text-yellow-600 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        <span>Kembali ke Laman Utama</span>
    </a>

    <!-- Floating Back Button for Mobile -->
    <a href="{{ url('/') }}" class="floating-back-button items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
    </a>

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left side - Background Image -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center bg-image-animation"
             style="background-image: url('https://images.unsplash.com/photo-1533240332313-0db49b459ad6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80');">
            <div class="h-full w-full bg-gradient-to-r from-yellow-500/70 to-yellow-700/50 flex items-center justify-center p-12">
                <div class="text-white max-w-md">
                    <h1 class="text-4xl font-bold mb-6">Sertai Komuniti OFYS</h1>
                    <p class="text-xl">Daftar untuk meneroka pengembaraan luar yang menakjubkan di Malaysia.</p>
                </div>
            </div>
        </div>

        <!-- Right side - Registration Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-3xl">OFYS</a>
                    <h2 class="mt-6 text-2xl font-bold text-gray-900">Daftar Akaun Baru</h2>
                    <p class="mt-2 text-gray-600">Atau <a href="{{ route('login') }}" class="text-yellow-500 hover:text-yellow-600 font-medium">log masuk ke akaun sedia ada</a></p>
                </div>

                @livewire('auth.register')
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
