<x-app-layout>
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
             style="background-image: url('https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');">
            <div class="h-full w-full bg-gradient-to-r from-yellow-500/70 to-yellow-700/50 flex items-center justify-center p-12">
                <div class="text-white max-w-md">
                    <h1 class="text-4xl font-bold mb-6">Selamat Kembali ke OFYS</h1>
                    <p class="text-xl">Terokai pengembaraan luar yang menakjubkan di Malaysia bersama kami.</p>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-3xl">OFYS</a>
                    <h2 class="mt-6 text-2xl font-bold text-gray-900">Log Masuk ke Akaun Anda</h2>
                    <p class="mt-2 text-gray-600">Atau <a href="{{ route('register') }}" class="text-yellow-500 hover:text-yellow-600 font-medium">daftar akaun baru</a></p>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @include('auth.login-form_livewire_removed')

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Atau log masuk dengan</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-2xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>

                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-2xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
