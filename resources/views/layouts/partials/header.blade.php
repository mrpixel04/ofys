<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-yellow-500 font-bold text-2xl">
                        OFYS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Utama') }}
                    </a>
                    <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Aktiviti') }}
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Tentang Kami') }}
                    </a>
                    @auth
                        @php($role = Auth::user()->role)
                        @if(!in_array($role, ['admin','provider','ADMIN','PROVIDER']))
                            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                {{ __('Papan Pemuka Pelanggan') }}
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Hubungi') }}
                    </a>
                </div>
            </div>

            <!-- Right side buttons -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Language Switcher -->
                <div class="relative mr-3 lang-dropdown">
                    <button type="button" class="lang-dropdown-trigger flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <span class="mr-1 text-sm">{{ session('locale') == 'en' ? 'EN' : 'MS' }}</span>
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="lang-dropdown-content absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-50 hidden">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ session('locale') == 'en' ? 'bg-gray-100' : '' }}">
                                <div class="flex items-center">
                                    <span class="ml-2">English</span>
                                </div>
                            </a>
                            <a href="{{ route('language.switch', 'ms') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ session('locale') == 'ms' ? 'bg-gray-100' : '' }}">
                                <div class="flex items-center">
                                    <span class="ml-2">Bahasa Melayu</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('Log Masuk') }}
                    </a>
                    <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium ml-2">
                        {{ __('Daftar') }}
                    </a>
                @else
                    <div class="ml-3 relative user-dropdown">
                        <button type="button" class="user-dropdown-trigger flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        <div class="user-dropdown-content origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden"
                             role="menu"
                             aria-orientation="vertical"
                             tabindex="-1">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->name }}
                            </div>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Papan Pemuka Admin') }}</a>
                            @elseif(Auth::user()->role === 'provider')
                                <a href="{{ route('provider.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Papan Pemuka Penyedia') }}</a>
                            @endif
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Tetapan') }}</a>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                @csrf
                                <button type="button" onclick="confirmLogout('logout-form-desktop')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Log Keluar') }}</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button"
                       class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-500"
                       aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="mobile-menu-icon-open h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="mobile-menu-icon-close hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="mobile-menu sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Utama
            </a>
            <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Aktiviti
            </a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Tentang Kami
            </a>
            @auth
                @php($role = Auth::user()->role)
                @if(!in_array($role, ['admin','provider','ADMIN','PROVIDER']))
                        <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('Papan Pemuka Pelanggan') }}
                    </a>
                @endif
            @endauth

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
                    @endif
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Tetapan') }}</a>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <button type="button" onclick="confirmLogout('logout-form-mobile')" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">{{ __('Log Keluar') }}</button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>

<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">{{ __('Sahkan Log Keluar') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    {{ __('Adakah anda pasti mahu log keluar? Anda perlu log masuk semula untuk akses akaun anda.') }}
                </p>
            </div>
            <div class="flex justify-center gap-4 mt-4">
                <button id="cancel-logout" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    {{ __('Batal') }}
                </button>
                <button id="confirm-logout" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    {{ __('Ya, Log Keluar') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentLogoutForm = null;

    function confirmLogout(formId) {
        currentLogoutForm = document.getElementById(formId);
        document.getElementById('logout-modal').classList.remove('hidden');
    }

    document.getElementById('confirm-logout').addEventListener('click', function() {
        if (currentLogoutForm) {
            currentLogoutForm.submit();
        }
    });

    document.getElementById('cancel-logout').addEventListener('click', function() {
        document.getElementById('logout-modal').classList.add('hidden');
        currentLogoutForm = null;
    });

    // Close modal when clicking outside
    document.getElementById('logout-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            currentLogoutForm = null;
        }
    });
</script>
