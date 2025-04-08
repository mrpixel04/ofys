<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OFYS') }} - Provider Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/provider.js'])

    <!-- jQuery - This will be loaded by provider.js -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .nav-item {
            position: relative;
            z-index: 10;
            pointer-events: auto;
        }

        .hidden-mobile {
            display: none;
        }

        @media (min-width: 768px) {
            .hidden-mobile {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Sidebar for larger screens -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <!-- Sidebar component -->
            <div class="flex flex-grow flex-col overflow-y-auto bg-gradient-to-b from-teal-500 to-emerald-600 shadow-xl">
                <div class="flex items-center justify-center h-16 px-4 bg-teal-600 bg-opacity-20">
                    <div class="text-xl font-bold text-white">
                        {{ config('app.name', 'OFYS') }} Provider
                    </div>
                </div>
                <div class="flex flex-col flex-grow mt-5 px-2">
                    <nav class="flex-1 space-y-1">
                        <a href="{{ route('provider.dashboard') }}" class="{{ request()->routeIs('provider.dashboard') ? 'bg-teal-700 bg-opacity-60 text-white' : 'text-teal-100 hover:bg-teal-600 hover:bg-opacity-50' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('provider.shop-info') }}" class="{{ request()->routeIs('provider.shop-info') ? 'bg-teal-700 bg-opacity-60 text-white' : 'text-teal-100 hover:bg-teal-600 hover:bg-opacity-50' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Shop Information
                        </a>

                        <a href="{{ route('provider.bookings') }}" class="{{ request()->routeIs('provider.bookings') ? 'bg-teal-700 bg-opacity-60 text-white' : 'text-teal-100 hover:bg-teal-600 hover:bg-opacity-50' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Bookings
                        </a>

                        <a href="{{ route('provider.simple-activities') }}" class="{{ request()->routeIs('provider.simple-activities') || request()->routeIs('provider.activities') ? 'bg-teal-700 bg-opacity-60 text-white' : 'text-teal-100 hover:bg-teal-600 hover:bg-opacity-50' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Activities
                        </a>

                        <div class="pt-6 mt-6 border-t border-teal-400 border-opacity-30">
                            <a href="{{ route('provider.simple-profile') }}" class="{{ request()->routeIs('provider.simple-profile') ? 'bg-teal-700 bg-opacity-60 text-white' : 'text-teal-100 hover:bg-teal-600 hover:bg-opacity-50' }} group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left text-teal-100 hover:bg-teal-600 hover:bg-opacity-50 group flex items-center px-4 py-3 text-sm font-medium rounded-md nav-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 flex-shrink-0 text-teal-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden">
            <div class="bg-gradient-to-r from-teal-500 to-emerald-600 px-4 py-3 flex items-center justify-between">
                <div class="flex-1 flex items-center">
                    <div class="text-lg font-bold text-white">
                        {{ config('app.name', 'OFYS') }} Provider
                    </div>
                </div>
                <div>
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md inline-flex items-center justify-center text-white hover:bg-teal-600 focus:outline-none">
                        <span class="sr-only">Open menu</span>
                        <svg id="mobile-menu-icon-open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="mobile-menu-icon-close" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu panel -->
            <div id="mobile-menu-panel" class="hidden bg-teal-50 border-b border-teal-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('provider.dashboard') }}" class="{{ request()->routeIs('provider.dashboard') ? 'bg-teal-600 text-white' : 'text-teal-800 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('provider.shop-info') }}" class="{{ request()->routeIs('provider.shop-info') ? 'bg-teal-600 text-white' : 'text-teal-800 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        Shop Information
                    </a>
                    <a href="{{ route('provider.bookings') }}" class="{{ request()->routeIs('provider.bookings') ? 'bg-teal-600 text-white' : 'text-teal-800 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        Bookings
                    </a>
                    <a href="{{ route('provider.simple-activities') }}" class="{{ request()->routeIs('provider.simple-activities') || request()->routeIs('provider.activities') ? 'bg-teal-600 text-white' : 'text-teal-800 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        Activities
                    </a>
                    <a href="{{ route('provider.simple-profile') }}" class="{{ request()->routeIs('provider.simple-profile') ? 'bg-teal-600 text-white' : 'text-teal-800 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        My Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-teal-800 hover:bg-teal-500 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64">
            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div id="success-alert" class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            {{ session('success') }}
                                        </p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button type="button" class="close-alert inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                                <span class="sr-only">Dismiss</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div id="error-alert" class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">
                                            {{ session('error') }}
                                        </p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button type="button" class="close-alert inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                                <span class="sr-only">Dismiss</span>
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Page header -->
                        <div class="mb-6">
                            <h1 class="text-2xl font-semibold text-gray-900">@yield('header', 'Dashboard')</h1>
                            @hasSection('header_actions')
                                <div class="mt-4">
                                    @yield('header_actions')
                                </div>
                            @endif
                        </div>

                        <!-- Page content -->
                        <div class="py-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal container for reusable modals -->
    <div id="modal-container"></div>

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
