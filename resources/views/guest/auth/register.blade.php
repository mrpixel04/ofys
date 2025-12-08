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

    <!-- Removed back buttons for a cleaner headerless look on register page -->

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left side - Background Image -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center bg-image-animation"
             style="background-image: url('https://images.unsplash.com/photo-1533240332313-0db49b459ad6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80');">
            <div class="h-full w-full bg-gradient-to-r from-yellow-500/70 to-yellow-700/50 flex items-center justify-center p-12">
                <div class="text-white max-w-md">
                    <h1 class="text-4xl font-bold mb-6">{{ __('Join the OFYS Community') }}</h1>
                    <p class="text-xl">{{ __('Register to explore amazing outdoor adventures in Malaysia.') }}</p>
                </div>
            </div>
        </div>

        <!-- Right side - Registration Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-3xl">OFYS</a>
                    <h2 class="mt-6 text-2xl font-bold text-gray-900">{{ __('Create New Account') }}</h2>
                    <p class="mt-2 text-gray-600">{{ __('Or') }} <a href="{{ route('login') }}" class="text-yellow-500 hover:text-yellow-600 font-medium">{{ __('log in to existing account') }}</a></p>
                </div>

                @include('guest.auth.register-form_livewire_removed')
            </div>
        </div>
    </div>
</x-app-layout>
