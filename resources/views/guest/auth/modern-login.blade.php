<x-app-layout>
<style>
    /* Base animations */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes slideInRight {
        0% {
            transform: translateX(50px);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        0% {
            transform: translateX(-50px);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        0% {
            transform: translateY(30px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -100% 0;
        }
        100% {
            background-position: 100% 0;
        }
    }

    /* Apply animations to elements */
    .animate-fade-in {
        animation: fadeIn 0.8s ease forwards;
    }

    .animate-slide-right {
        animation: slideInRight 0.8s ease forwards;
    }

    .animate-slide-left {
        animation: slideInLeft 0.8s ease forwards;
    }

    .animate-slide-up {
        animation: slideInUp 0.8s ease forwards;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    /* Animation delays */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-600 { animation-delay: 0.6s; }
    .delay-700 { animation-delay: 0.7s; }
    .delay-800 { animation-delay: 0.8s; }

    /* Special animations */
    .shimmer-bg {
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }

    .login-card {
        transition: all 0.3s ease;
        opacity: 0;
        animation: fadeIn 0.8s ease forwards 0.3s;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .login-image-overlay {
        position: relative;
        overflow: hidden;
    }

    .login-image-overlay::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 3s infinite;
        z-index: 1;
    }

    .feature-icon {
        transition: all 0.3s ease;
    }

    .feature-row:hover .feature-icon {
        transform: scale(1.2);
        background-color: rgba(255, 255, 255, 0.3);
    }

    .input-field {
        transition: all 0.3s ease;
    }

    .input-field:focus {
        transform: translateY(-2px);
    }

    .login-button {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .login-button::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: all 0.6s ease;
    }

    .login-button:hover::after {
        left: 100%;
    }

    .form-title {
        background: linear-gradient(90deg, #f59e0b, #d97706, #f59e0b);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 3s linear infinite;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden login-card">
            <div class="flex flex-col md:flex-row">
                <!-- Left side - Image with text overlay -->
                <div class="md:w-1/2 relative login-image-overlay">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-yellow-600 opacity-90"></div>
                    <img
                        src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                        alt="OFYS Adventure"
                        class="h-full w-full object-cover"
                    >
                    <div class="absolute inset-0 flex items-center justify-center p-10">
                        <div class="text-white text-center">
                            <h2 class="text-3xl md:text-4xl font-bold mb-4 animate-slide-left">{{ __('Welcome Back!') }}</h2>
                            <div class="w-16 h-1 bg-white mx-auto mb-6 animate-slide-right delay-200"></div>
                            <p class="text-lg md:text-xl mb-8 animate-slide-left delay-300">{{ __('Explore more amazing outdoor adventures in Malaysia with us.') }}</p>
                            <div class="space-y-4">
                                <div class="flex items-center feature-row animate-slide-left delay-400">
                                    <div class="rounded-full bg-white/20 p-2 mr-3 feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-white text-lg">{{ __('Quality Assured Activities') }}</span>
                                </div>
                                <div class="flex items-center feature-row animate-slide-left delay-500">
                                    <div class="rounded-full bg-white/20 p-2 mr-3 feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-white text-lg">{{ __('Safe & Easy Booking') }}</span>
                                </div>
                                <div class="flex items-center feature-row animate-slide-left delay-600">
                                    <div class="rounded-full bg-white/20 p-2 mr-3 feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                    </div>
                                    <span class="text-white text-lg">{{ __('Outdoor Activity Enthusiast Community') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side - Login Form -->
                <div class="md:w-1/2 p-8 md:p-12">
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-8 animate-slide-up">
                            <a href="{{ url('/') }}" class="inline-block mb-4">
                                <span class="text-yellow-500 font-bold text-4xl form-title animate-pulse">OFYS</span>
                            </a>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2 animate-slide-up delay-200">{{ __('Log In to Your Account') }}</h2>
                            <p class="text-gray-600 animate-slide-up delay-300">{{ __('Enter your information to access your account') }}</p>
                        </div>

                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md animate-slide-up delay-200" role="alert">
                                <p class="font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md animate-slide-up delay-200" role="alert">
                                <p class="font-medium">{{ __('There was an error with your login:') }}</p>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST" id="login-form" class="space-y-6">
                            @csrf
                            <div class="animate-slide-up delay-300">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        required
                                        class="pl-10 appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 transition input-field"
                                        placeholder="example@email.com"
                                        value="{{ old('email') }}"
                                    >
                                </div>
                            </div>

                            <div class="animate-slide-up delay-400">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="current-password"
                                        required
                                        class="pl-10 appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 transition input-field"
                                        placeholder="••••••••"
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" id="toggle-password" class="text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition">
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

                            <div class="flex items-center justify-between animate-slide-up delay-500">
                                <div class="flex items-center">
                                    <input
                                        id="remember_me"
                                        name="remember"
                                        type="checkbox"
                                        class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300 rounded transition"
                                    >
                                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-yellow-600 hover:text-yellow-500 transition">
                                        {{ __('Forgot password?') }}
                                    </a>
                                </div>
                            </div>

                            <div class="animate-slide-up delay-600">
                                <button type="submit" id="login-button" class="login-button group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                                    <span id="login-text" class="flex items-center">
                                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Log In') }}
                                    </span>
                                    <span id="login-loading" class="hidden items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('Logging in...') }}
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="mt-8 animate-slide-up delay-700">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white text-gray-500">
                                        {{ __('Or sign in with') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-3">
                                <a href="#" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 animate-slide-up delay-700">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill="#EA4335" d="M12.24 10.2v3.72h5.3c-.21 1.32-.58 2.29-1.18 3.04-.75.95-1.92 1.97-4.12 1.97-3.63 0-6.49-2.94-6.49-6.56 0-3.62 2.86-6.56 6.49-6.56 1.96 0 3.28.83 4.04 1.52l2.76-2.66C17.77 2.45 15.35 1.5 12.24 1.5 6.74 1.5 2.25 6.04 2.25 11.62S6.74 21.75 12.24 21.75c3.41 0 5.9-1.11 7.35-3.17 1.34-1.86 1.78-4.23 1.78-6.23 0-.62-.04-1.2-.13-1.75H12.24z"/>
                                        <path fill="#4285F4" d="M3.45 7.52l3.2 2.35c.87-2.17 2.79-3.51 5.59-3.51 1.96 0 3.28.83 4.04 1.52l2.76-2.66C17.77 2.45 15.35 1.5 12.24 1.5 8.31 1.5 5 3.78 3.45 7.52z"/>
                                        <path fill="#FBBC05" d="M12.24 21.75c2.31 0 4.22-.76 5.62-2.08l-3.1-2.51c-.73.52-1.67.88-2.52.88-2.2 0-4.07-1.48-4.75-3.52l-3.2 2.5c1.53 3.73 4.84 5.73 7.95 5.73z"/>
                                        <path fill="#34A853" d="M3.71 16.02l3.2-2.5c-.21-.65-.33-1.35-.33-2.12 0-.77.12-1.47.33-2.12l-3.2-2.35C2.94 8.3 2.49 9.91 2.49 11.4c0 1.49.45 3.11 1.22 4.62z"/>
                                        <path fill="none" d="M3.71 16.02l3.2-2.5"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="mt-8 text-center animate-slide-up delay-800">
                            <p class="text-gray-600">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}" class="font-medium text-yellow-600 hover:text-yellow-500 ml-1 transition">
                                    {{ __('Register now') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ensure jQuery is available for the login page interactions -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Add JavaScript for login form enhancements -->
<script>
    $(document).ready(function() {
        // Keep animations smooth and single-run (no manual opacity toggles)

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
            $('#login-loading').removeClass('hidden').css('display', 'flex');
            $('#login-button').prop('disabled', true).addClass('opacity-75');

            // Continue with form submission
            return true;
        });

        // Focus on email field on page load
        $('#email').focus();

        // Add hover effects to form inputs
        $('.input-field').hover(
            function() {
                $(this).addClass('shadow-md');
            },
            function() {
                $(this).removeClass('shadow-md');
            }
        );
    });
</script>
</x-app-layout>
