@extends('layouts.simple-app')

@section('content')
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

    .bg-login-image {
        background-image: url("https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80");
        background-size: cover;
        background-position: center;
        height: 100%;
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
    <div class="hidden md:block md:w-1/2 bg-login-image bg-image-animation">
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

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email') }}</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                            value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('auth.password') }}</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">

                        <!-- Password Toggle Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <button type="button" id="toggle-password" class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg id="eye-show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg id="eye-hide" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">{{ __('auth.remember_me') }}</label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-yellow-500 hover:text-yellow-600">{{ __('auth.forgot_password') }}</a>
                    </div>
                </div>

                <div>
                    <button type="submit" id="login-button" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                        <span id="login-text">{{ __('auth.login') }}</span>
                        <span id="login-loading" class="hidden flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('auth.logging_in') }}
                        </span>
                    </button>
                </div>
            </form>

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
                        <a href="{{ route('auth.google.redirect') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-2xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
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

<!-- Add JavaScript for login form enhancements -->
<script>
    $(document).ready(function() {
        // Password toggle functionality
        $('#toggle-password').click(function() {
            const passwordField = $('#password');
            const eyeShow = $('#eye-show');
            const eyeHide = $('#eye-hide');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                eyeShow.addClass('hidden');
                eyeHide.removeClass('hidden');
            } else {
                passwordField.attr('type', 'password');
                eyeShow.removeClass('hidden');
                eyeHide.addClass('hidden');
            }
        });

        // Form submission with loading state
        $('#login-form').submit(function() {
            $('#login-text').addClass('hidden');
            $('#login-loading').removeClass('hidden');
            $('#login-button').prop('disabled', true).addClass('opacity-75');

            // Continue with form submission
            return true;
        });

        // Focus on email field on page load
        $('#email').focus();
    });
</script>
@endsection
