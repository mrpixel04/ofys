@if(!isset($headless) || !$headless)
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

    <!-- Tailwind CSS - Updated to proper usage -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            plugins: [
                function({ addVariant }) {
                    addVariant('hocus', ['&:hover', '&:focus'])
                }
            ]
        }
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        /* Toast notification styles */
        .toast {
            position: fixed;
            right: 20px;
            top: 20px;
            max-width: 350px;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.3s ease-in-out;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sidebar styles */
        .sidebar-open {
            transform: translateX(0) !important;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
        }

        /* Active menu item */
        .menu-active {
            background-color: rgba(147, 51, 234, 0.5);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        /* Submenu items */
        .submenu {
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .submenu.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-800 to-purple-900 text-white lg:translate-x-0 lg:static lg:inset-0 shadow-xl">
            <div class="flex items-center justify-center h-16 bg-gradient-to-r from-purple-900 to-purple-800">
                <h2 class="text-xl font-bold">Admin Panel</h2>
             </div>
            <nav class="mt-5 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('admin.bookings') ?? '#' }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.bookings') ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('Bookings') }}
                </a>

                <!-- Providers Dropdown -->
                <div class="dropdown-menu">
                    <button class="dropdown-toggle flex items-center w-full px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.providers*') ? 'menu-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        {{ __('Providers') }}
                        <svg class="w-4 h-4 ml-auto transition-transform duration-200 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="submenu pl-4 pr-2 mt-2 space-y-1 rounded-md {{ request()->routeIs('admin.providers*') ? 'active' : '' }}">
                        <a href="{{ route('admin.simple-providers-basic') }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.simple-providers-basic') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Providers List') }}
                        </a>
                        <a href="{{ route('admin.providers.activities') ?? '#' }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.providers.activities') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            {{ __('Activities') }}
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.customers') ?? '#' }}" class="flex items-center px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.customers') ? 'menu-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('Customers') }}
                </a>

                <!-- Settings Dropdown -->
                <div class="dropdown-menu">
                    <button class="dropdown-toggle flex items-center w-full px-6 py-3 text-white hover:bg-purple-700/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.settings*') || request()->routeIs('admin.profile') ? 'menu-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ __('Settings') }}
                        <svg class="w-4 h-4 ml-auto transition-transform duration-200 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="submenu pl-4 pr-2 mt-2 space-y-1 rounded-md {{ request()->routeIs('admin.settings*') || request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile') ?? '#' }}" class="flex items-center py-2 px-4 text-white hover:bg-purple-600/50 rounded-md transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Profile') }}
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
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1">
            <!-- Top Navbar for Mobile -->
            <nav class="bg-white shadow-sm lg:hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <!-- Mobile menu button -->
                                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                                <span class="ml-2 text-xl font-bold text-purple-800">Admin Panel</span>
                            </div>
                        </div>
                </div>
            </nav>

            <!-- Toast Messages -->
            @if(session('success'))
            <div id="success-toast" class="toast bg-green-50 border-l-4 border-green-500 p-4 shadow-lg rounded-lg flex items-start">
                <div class="text-green-500 flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-100 inline-flex h-8 w-8 close-toast">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div id="error-toast" class="toast bg-red-50 border-l-4 border-red-500 p-4 shadow-lg rounded-lg flex items-start">
                <div class="text-red-500 flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-100 inline-flex h-8 w-8 close-toast">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('content')
                </div>
            </main>

            <!-- Modals Section -->
            @yield('modals')
        </div>
    </div>

    <!-- jQuery and JavaScript -->
    <script>
        $(document).ready(function() {
            // Toggle mobile menu
            $('#mobile-menu-button').on('click', function() {
                $('#sidebar').toggleClass('sidebar-open');
            });

            // Handle dropdown menus
            $('.dropdown-toggle').click(function() {
                const submenu = $(this).next('.submenu');
                const arrow = $(this).find('.dropdown-arrow');

                submenu.toggleClass('active');

                if (submenu.hasClass('active')) {
                    arrow.css('transform', 'rotate(180deg)');
                } else {
                    arrow.css('transform', 'rotate(0)');
                }
            });

            // Initialize dropdowns to show active sections
            $('.dropdown-menu').each(function() {
                const submenu = $(this).find('.submenu');
                const arrow = $(this).find('.dropdown-arrow');

                if (submenu.hasClass('active')) {
                    arrow.css('transform', 'rotate(180deg)');
                }
            });

            // Initialize toast notifications
            $('.toast').each(function() {
                $(this).addClass('show');

                setTimeout(() => {
                    $(this).removeClass('show');
                    setTimeout(() => $(this).remove(), 300);
                }, 5000);
            });

            // Close toast on button click
            $('.close-toast').on('click', function() {
                const toast = $(this).closest('.toast');
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 300);
            });
        });
    </script>

    <!-- Page-specific scripts -->
    @yield('scripts')
</body>
</html>
@else
@yield('content')
@endif
