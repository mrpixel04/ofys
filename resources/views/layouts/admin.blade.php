<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OFYS - Outdoor For Your Soul') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-800 to-purple-900 text-white transition-all duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-xl">
            <div class="flex items-center justify-center h-16 bg-gradient-to-r from-purple-900 to-purple-800">
                <h2 class="text-xl font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-5 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-700/50 shadow-md' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    {{ __('admin.dashboard') }}
                </a>

                <a href="{{ route('admin.bookings') ?? '#' }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.bookings') ? 'bg-purple-700/50 shadow-md' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('admin.bookings') }}
                </a>

                <!-- Providers Dropdown -->
                <div class="providers-dropdown">
                    <button class="providers-dropdown-toggle flex items-center w-full px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.providers*') ? 'bg-purple-700/50 shadow-md' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        {{ __('admin.providers') }}
                        <svg class="w-4 h-4 ml-auto transition-transform duration-200 providers-dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="providers-dropdown-content pl-4 pr-2 mt-2 space-y-1 rounded-md {{ request()->routeIs('admin.providers*') ? '' : 'hidden' }}">
                        <a href="{{ route('admin.providers') }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.providers') && !request()->routeIs('admin.providers.activities') ? 'bg-purple-600/50 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('admin.providers') }}
                        </a>
                        <a href="{{ route('admin.providers.activities') ?? '#' }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.providers.activities') ? 'bg-purple-600/50 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            {{ __('admin.activities') }}
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.customers') ?? '#' }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.customers') ? 'bg-purple-700/50 shadow-md' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('admin.customers') }}
                </a>

                <!-- Settings Dropdown -->
                <div class="settings-dropdown">
                    <button class="settings-dropdown-toggle flex items-center w-full px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.settings*') || request()->routeIs('admin.profile') ? 'bg-purple-700/50 shadow-md' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ __('admin.settings') }}
                        <svg class="w-4 h-4 ml-auto transition-transform duration-200 settings-dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="settings-dropdown-content pl-4 pr-2 mt-2 space-y-1 rounded-md {{ request()->routeIs('admin.settings*') || request()->routeIs('admin.profile') ? '' : 'hidden' }}">
                        <a href="{{ route('admin.settings') }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.settings') && !request()->routeIs('admin.profile') ? 'bg-purple-600/50 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065"></path></svg>
                            {{ __('admin.system_settings') }}
                        </a>
                        <a href="{{ route('admin.profile') ?? '#' }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-purple-600/50 shadow-sm' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('admin.profile') }}
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Admin Profile & Logout Section -->
            <div class="mt-auto pt-4 pb-8">
                <div class="px-4">
                    <div class="border-t border-purple-800 pt-4 mt-4"></div>
                    <div class="flex items-center px-2 py-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-purple-300 flex items-center justify-center text-purple-800 font-semibold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-purple-200">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full mt-2 flex items-center justify-center px-4 py-3 rounded-md text-white bg-purple-800 hover:bg-purple-900 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        $(document).ready(function() {
            // Admin dropdown functionality
            $('.providers-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $('.providers-dropdown-content').toggleClass('hidden');
                $('.providers-dropdown-arrow').toggleClass('transform rotate-180');
            });

            $('.settings-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                $('.settings-dropdown-content').toggleClass('hidden');
                $('.settings-dropdown-arrow').toggleClass('transform rotate-180');
            });

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.providers-dropdown').length) {
                    $('.providers-dropdown-content').addClass('hidden');
                    $('.providers-dropdown-arrow').removeClass('transform rotate-180');
                }
                if (!$(e.target).closest('.settings-dropdown').length) {
                    $('.settings-dropdown-content').addClass('hidden');
                    $('.settings-dropdown-arrow').removeClass('transform rotate-180');
                }
            });
        });
    </script>
</body>
</html>
