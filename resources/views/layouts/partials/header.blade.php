<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo + Navigation -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-2xl">
                        OFYS
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:ml-10 md:flex md:items-center md:space-x-2">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50' }} px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50' }} px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                        {{ __('Activities') }}
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50' }} px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                        {{ __('About Us') }}
                    </a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-yellow-600 bg-yellow-50' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50' }} px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                        {{ __('Contact') }}
                    </a>
                </nav>
            </div>

            <!-- Right: Language + Auth -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <!-- Language Switcher - Simple Toggle Buttons -->
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                    <a href="{{ route('language.switch', 'en') }}"
                       class="px-3 py-1.5 text-xs font-medium {{ app()->getLocale() == 'en' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                        EN
                    </a>
                    <a href="{{ route('language.switch', 'ms') }}"
                       class="px-3 py-1.5 text-xs font-medium {{ app()->getLocale() == 'ms' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                        BM
                    </a>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-yellow-600 px-3 py-2 text-sm font-medium">
                        {{ __('Log In') }}
                    </a>
                    <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        {{ __('Register') }}
                    </a>
                @else
                    <!-- User Dropdown -->
                    <div class="relative" id="user-dropdown">
                        <button type="button" onclick="toggleUserDropdown()" class="flex items-center space-x-2 text-gray-600 hover:text-yellow-600 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center text-white text-sm font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            @if(in_array(Auth::user()->role, ['admin', 'ADMIN']))
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Admin Dashboard') }}</a>
                            @elseif(in_array(Auth::user()->role, ['provider', 'PROVIDER']))
                                <a href="{{ route('provider.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('Provider Dashboard') }}</a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('My Dashboard') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" onclick="toggleMobileMenu()" class="text-gray-600 hover:text-yellow-600 p-2">
                    <svg id="mobile-menu-icon-open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="mobile-menu-icon-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600' }} block px-3 py-2 rounded-lg text-base font-medium">
                {{ __('Home') }}
            </a>
            <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600' }} block px-3 py-2 rounded-lg text-base font-medium">
                {{ __('Activities') }}
            </a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600' }} block px-3 py-2 rounded-lg text-base font-medium">
                {{ __('About Us') }}
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-600' }} block px-3 py-2 rounded-lg text-base font-medium">
                {{ __('Contact') }}
            </a>
        </div>

        <!-- Mobile Language Switcher -->
        <div class="px-4 py-3 border-t border-gray-100">
            <p class="text-xs font-medium text-gray-400 uppercase mb-2">{{ __('Language') }}</p>
            <div class="flex space-x-2">
                <a href="{{ route('language.switch', 'en') }}"
                   class="flex-1 text-center px-3 py-2 text-sm font-medium rounded-lg {{ app()->getLocale() == 'en' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    English
                </a>
                <a href="{{ route('language.switch', 'ms') }}"
                   class="flex-1 text-center px-3 py-2 text-sm font-medium rounded-lg {{ app()->getLocale() == 'ms' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Bahasa Melayu
                </a>
            </div>
        </div>

        <!-- Mobile Auth -->
        <div class="px-4 py-3 border-t border-gray-100">
            @guest
                <div class="flex space-x-3">
                    <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg">
                        {{ __('Log In') }}
                    </a>
                    <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg">
                        {{ __('Register') }}
                    </a>
                </div>
            @else
                <div class="flex items-center mb-3">
                    <div class="h-10 w-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-medium">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                @if(in_array(Auth::user()->role, ['admin', 'ADMIN']))
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">{{ __('Admin Dashboard') }}</a>
                @elseif(in_array(Auth::user()->role, ['provider', 'PROVIDER']))
                    <a href="{{ route('provider.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">{{ __('Provider Dashboard') }}</a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">{{ __('My Dashboard') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-gray-50 rounded-lg">
                        {{ __('Log Out') }}
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('mobile-menu-icon-open');
    const iconClose = document.getElementById('mobile-menu-icon-close');

    menu.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
}

function toggleUserDropdown() {
    const menu = document.getElementById('user-dropdown-menu');
    menu.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('user-dropdown');
    const menu = document.getElementById('user-dropdown-menu');
    if (dropdown && menu && !dropdown.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script>
