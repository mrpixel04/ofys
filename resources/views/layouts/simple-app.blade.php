<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>{{ config('app.name', 'OFYS - Outdoor For Your Soul') }}</title>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <!-- Tailwind CSS Play CDN -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <style type="text/tailwindcss">
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                min-width: 10rem;
                padding: 0.5rem 0;
                margin-top: 0.5rem;
                background-color: white;
                border-radius: 0.375rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                z-index: 50;
            }
            .dropdown-content.show {
                display: block;
            }
            .mobile-menu {
                display: none;
            }
            .mobile-menu.show {
                display: block;
            }
            .aspect-w-1 {
                position: relative;
                padding-bottom: 100%;
            }
            .aspect-w-1 > div {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
            }
            .hidden {
                display: none !important;
            }

            /* Professional menu styling */
            .nav-link {
                padding: 0.25rem 0;
                margin: 0 0.5rem;
                transition: all 0.2s ease;
                position: relative;
                font-weight: 500;
            }

            .nav-link:after {
                content: '';
                position: absolute;
                width: 100%;
                height: 2px;
                bottom: -5px;
                left: 0;
                background-color: #eab308;
                transform: scaleX(0);
                transition: transform 0.2s ease;
            }

            .nav-link:hover:after {
                transform: scaleX(1);
            }

            .nav-link.active {
                color: #eab308;
                font-weight: 600;
            }

            .nav-link.active:after {
                transform: scaleX(1);
            }

            .btn-login {
                padding: 0.5rem 1.25rem;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                font-weight: 500;
            }

            .btn-login:hover {
                background-color: #f3f4f6;
            }

            .btn-register {
                padding: 0.5rem 1.25rem;
                border-radius: 0.375rem;
                background-color: #eab308;
                color: white;
                transition: all 0.2s ease;
                font-weight: 500;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }

            .btn-register:hover {
                background-color: #d97706;
            }

            /* Additional styles to ensure menu appears */
            @media (min-width: 640px) {
                .sm\:flex {
                    display: flex !important;
                }
                .sm\:items-center {
                    align-items: center !important;
                }
                .sm\:space-x-8 > * + * {
                    margin-left: 2rem !important;
                }
                .sm\:hidden {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-2xl">
                                OFYS
                            </a>
                        </div>
                    </div>

                    <!-- Navigation Links on right side -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-8" id="desktop-menu">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : 'text-gray-600 hover:text-gray-900' }}">
                            {{ __('Utama') }}
                        </a>
                        <a href="{{ route('activities.index') }}" class="nav-link {{ request()->routeIs('activities.*') ? 'active' : 'text-gray-600 hover:text-gray-900' }}">
                            {{ __('Aktiviti') }}
                        </a>
                        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : 'text-gray-600 hover:text-gray-900' }}">
                            {{ __('Tentang Kami') }}
                        </a>
                        <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : 'text-gray-600 hover:text-gray-900' }}">
                            {{ __('Hubungi') }}
                        </a>

                        <!-- Language Switcher -->
                        <div class="relative ml-4 dropdown">
                            <button type="button" class="dropdown-trigger flex items-center text-gray-600 hover:text-gray-900 focus:outline-none font-medium">
                                <span class="text-sm">{{ strtoupper(app()->getLocale() === 'ms' ? 'MS' : 'EN') }} <i class="fas fa-chevron-down text-xs ml-1"></i></span>
                            </button>
                            <div class="dropdown-content">
                                <div class="py-1">
                                    <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <div class="flex items-center">
                                            <span>{{ __('English') }}</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('language.switch', 'ms') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <div class="flex items-center">
                                            <span>{{ __('Bahasa Melayu') }}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @guest
                            <a href="{{ route('login') }}" class="btn-login text-gray-600 hover:text-gray-900 ml-4">
                                {{ __('Log Masuk') }}
                            </a>
                            <a href="{{ route('register') }}" class="btn-register ml-2">
                                {{ __('Daftar') }}
                            </a>
                        @else
                            <div class="ml-3 relative dropdown">
                                <button type="button" class="dropdown-trigger flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <span class="sr-only">{{ __('Buka menu pengguna') }}</span>
                                    <div class="h-9 w-9 rounded-full bg-yellow-500 flex items-center justify-center text-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                                <div class="dropdown-content">
                                    <div class="py-1">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ Auth::user()->name }}
                                        </div>
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Papan Pemuka Admin') }}</a>
                                        @elseif(Auth::user()->role === 'provider')
                                            <a href="{{ route('provider.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Papan Pemuka Penyedia') }}</a>
                                        @else
                                            <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Papan Pemuka Saya') }}</a>
                                        @endif
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Tetapan') }}</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Log Keluar') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" id="mobile-menu-button"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none"
                                aria-expanded="false">
                            <span class="sr-only">{{ __('Buka menu utama') }}</span>
                            <!-- Icon when menu is closed -->
                            <svg id="mobile-menu-icon-open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Icon when menu is open -->
                            <svg id="mobile-menu-icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="mobile-menu sm:hidden" id="mobile-menu-panel">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('Utama') }}
                    </a>
                    <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('Aktiviti') }}
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('Tentang Kami') }}
                    </a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('Hubungi') }}
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    @guest
                        <div class="flex items-center px-4">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                {{ __('Log Masuk') }}
                            </a>
                            <a href="{{ route('register') }}" class="ml-4 block px-4 py-2 text-base font-medium text-white bg-yellow-500 hover:bg-yellow-600 rounded-md">
                                {{ __('Daftar') }}
                            </a>
                        </div>
                    @else
                        <div class="flex items-center px-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-yellow-500 flex items-center justify-center text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Papan Pemuka Admin') }}</a>
                            @elseif(Auth::user()->role === 'provider')
                                <a href="{{ route('provider.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Papan Pemuka Penyedia') }}</a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Papan Pemuka Saya') }}</a>
                            @endif
                            <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Tetapan') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Log Keluar') }}</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Logo and Description -->
                    <div class="md:col-span-2">
                        <h2 class="text-yellow-500 font-bold text-2xl mb-4">OFYS</h2>
                        <p class="text-gray-300 mb-4">Outdoor For Your Soul menawarkan pengalaman luar yang unik dan menarik di seluruh Malaysia. Hubungi kami untuk mengetahui lebih lanjut.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white font-semibold text-lg mb-4">{{ __('Pautan Pantas') }}</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white">{{ __('Utama') }}</a></li>
                            <li><a href="{{ route('activities.index') }}" class="text-gray-300 hover:text-white">{{ __('Aktiviti') }}</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">{{ __('Tentang Kami') }}</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">{{ __('Hubungi') }}</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-white font-semibold text-lg mb-4">{{ __('Hubungi Kami') }}</h3>
                        <ul class="space-y-2">
                            <li class="text-gray-300 flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                                <span>{{ __('123 Jalan Pengembaraan, Kuala Lumpur, Malaysia') }}</span>
                            </li>
                            <li class="text-gray-300 flex items-start">
                                <i class="fas fa-phone-alt mt-1 mr-2"></i>
                                <span>+60 12-345-6789</span>
                            </li>
                            <li class="text-gray-300 flex items-start">
                                <i class="fas fa-envelope mt-1 mr-2"></i>
                                <span>info@ofys.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} OFYS - Outdoor For Your Soul. {{ __('Semua hak terpelihara.') }}</p>
                </div>
            </div>
        </footer>

        <!-- Core JavaScript -->
        <script>
            // Use jQuery for better compatibility
            $(document).ready(function() {
                console.log('jQuery loaded and document ready');

                // Force menu to display on desktop
                if ($(window).width() >= 640) {
                    $('#desktop-menu').css('display', 'flex');
                }

                // Dropdown functionality
                $('.dropdown-trigger').click(function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).closest('.dropdown').find('.dropdown-content');
                    $('.dropdown-content').not($dropdown).removeClass('show');
                    $dropdown.toggleClass('show');
                });

                // Close dropdowns when clicking elsewhere
                $(document).click(function() {
                    $('.dropdown-content').removeClass('show');
                });

                // Mobile menu toggle
                $('#mobile-menu-button').click(function() {
                    $('#mobile-menu-panel').toggleClass('show');
                    $('#mobile-menu-icon-open').toggleClass('hidden');
                    $('#mobile-menu-icon-close').toggleClass('hidden');
                });
            });
        </script>
    </body>
</html>
