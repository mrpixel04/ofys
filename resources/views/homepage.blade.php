<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OFYS - Outdoor Untuk Jiwa Anda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown toggle
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent event from bubbling up
                    userDropdown.classList.toggle('hidden');

                    // Ensure dropdown is on top of everything
                    document.querySelectorAll('.z-50').forEach(el => {
                        if (el !== userDropdown) {
                            el.style.zIndex = '40';
                        }
                    });
                    userDropdown.style.zIndex = '999';
                });

                // Close the dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Success message close button
            const alertCloseButton = document.querySelector('.bg-green-100 svg');
            if (alertCloseButton) {
                alertCloseButton.addEventListener('click', function() {
                    const alert = this.closest('.bg-green-100');
                    alert.classList.add('hidden');
                });

                // Auto-hide success message after 5 seconds
                setTimeout(function() {
                    const alert = document.querySelector('.bg-green-100');
                    if (alert) {
                        alert.classList.add('hidden');
                    }
                }, 5000);
            }
        });
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen">
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
    @endif

    <!-- Header -->
    <header class="bg-white shadow-sm z-20 relative">
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
                        <a href="#" class="border-yellow-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Utama
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Aktiviti
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Destinasi
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Tentang Kami
                        </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Hubungi
                        </a>
                    </div>
                </div>

                <!-- Right side buttons -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <!-- Language Switcher -->
                    <div class="relative mr-3" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <span class="mr-1 text-sm">{{ session('locale') == 'en' ? 'EN' : 'MS' }}</span>
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-50">
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
                            Log Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium ml-2">
                            Daftar
                        </a>
                    @else
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center text-white">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </div>
                            <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-dropdown">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ Auth::user()->name }}
                                </div>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Admin Dashboard</a>
                                @elseif(Auth::user()->role === 'provider')
                                    <a href="{{ route('provider.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Provider Dashboard</a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">My Dashboard</a>
                                @endif
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="relative bg-gray-900 z-10">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Mount Kinabalu landscape">
            <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Temui Pengembaraan Seterusnya</h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">Terokai destinasi-destinasi yang menakjubkan dan aktiviti-aktiviti menarik di Malaysia bersama OFYS - pintu anda ke pengalaman luar yang tidak dapat dilupakan.</p>

            <!-- Search Form -->
            <div class="mt-10 max-w-xl">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <form class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="activity" class="block text-sm font-medium text-gray-700">Apa yang anda ingin lakukan?</label>
                                <div class="mt-1">
                                    <input type="text" name="activity" id="activity" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="Mendaki, Berkhemah, Berkayak...">
                                </div>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Di mana?</label>
                                <div class="mt-1">
                                    <input type="text" name="location" id="location" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="Bandar, Negeri, atau Kawasan">
                                </div>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Bila?</label>
                                <div class="mt-1">
                                    <input type="date" name="date" id="date" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Cari Pengembaraan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Activities Section -->
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Aktiviti Pilihan</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Temui pengembaraan luar dan pengalaman yang paling popular di Malaysia.
                </p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Activity Card 1: Hiking -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-60 w-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1464207687429-7505649dae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                             alt="Mendaki di Gunung Kinabalu"
                             class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-60"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="inline-block bg-yellow-500 rounded-full px-3 py-1 text-xs font-semibold text-white mr-2 mb-2">
                                Mendaki
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">Pendakian Gunung Kinabalu</h3>
                        <p class="mt-2 text-sm text-gray-500">Alami pemandangan yang menakjubkan di laluan pendakian gunung tertinggi di Malaysia.</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">RM249 / orang</span>
                            <a href="#" class="text-yellow-500 hover:text-yellow-600 font-medium">Lihat Butiran</a>
                        </div>
                    </div>
                </div>

                <!-- Activity Card 2: Camping -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-60 w-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1537225228614-56cc3556d7ed?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                             alt="Berkhemah di Taman Negara"
                             class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-60"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="inline-block bg-yellow-500 rounded-full px-3 py-1 text-xs font-semibold text-white mr-2 mb-2">
                                Berkhemah
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">Perkhemahan Taman Negara</h3>
                        <p class="mt-2 text-sm text-gray-500">Putuskan hubungan dan sambung semula dengan alam di tapak perkhemahan premium kami di hutan hujan tertua di dunia.</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">RM175 / malam</span>
                            <a href="#" class="text-yellow-500 hover:text-yellow-600 font-medium">Lihat Butiran</a>
                        </div>
                    </div>
                </div>

                <!-- Activity Card 3: Kayaking -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-60 w-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1623771702313-39dc4eba9333?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                             alt="Berkayak di Pulau Langkawi"
                             class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-60"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="inline-block bg-yellow-500 rounded-full px-3 py-1 text-xs font-semibold text-white mr-2 mb-2">
                                Berkayak
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">Berkayak di Pulau Langkawi</h3>
                        <p class="mt-2 text-sm text-gray-500">Jelajahi hutan bakau dan formasi batu kapur yang menakjubkan dengan pemandu kayak pakar kami.</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">RM165 / orang</span>
                            <a href="#" class="text-yellow-500 hover:text-yellow-600 font-medium">Lihat Butiran</a>
                        </div>
                    </div>
                </div>

                <!-- Activity Card 4: Snorkeling -->
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-60 w-full overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544551763-92ab472cad5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                             alt="Snorkeling di Pulau Perhentian"
                             class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-60"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="inline-block bg-yellow-500 rounded-full px-3 py-1 text-xs font-semibold text-white mr-2 mb-2">
                                Snorkeling
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">Snorkeling di Pulau Perhentian</h3>
                        <p class="mt-2 text-sm text-gray-500">Terokai kehidupan marin yang menakjubkan dan terumbu karang berwarna-warni di perairan jernih Pulau Perhentian.</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">RM189 / orang</span>
                            <a href="#" class="text-yellow-500 hover:text-yellow-600 font-medium">Lihat Butiran</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">
                    Lihat Semua Aktiviti
                </a>
            </div>
        </div>
    </div>

    <!-- Include Categories Section -->
    @include('sections.categories')

    <!-- Include Testimonials Section -->
    @include('sections.testimonials')

    <!-- Include Newsletter Section -->
    @include('sections.newsletter')

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-1">
                    <h3 class="text-xl font-bold text-yellow-400 mb-4">OFYS</h3>
                    <p class="text-gray-300 mb-4">Outdoor Untuk Jiwa Anda - Pintu anda ke pengembaraan dan penerokaan.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Pautan Pantas</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Utama</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Aktiviti</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Destinasi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Hubungi</a></li>
                    </ul>
                </div>

                <!-- Activities -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Aktiviti</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Berkhemah</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Mendaki</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Berkayak</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Snorkeling</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Memancing</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Langgan Surat Berita Kami</h3>
                    <p class="text-gray-300 mb-4">Dapatkan maklumat terkini tentang pengembaraan dan promosi kami.</p>
                    <form class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="E-mel anda" class="px-4 py-2 rounded-md text-gray-900 focus:ring-yellow-500 focus:border-yellow-500">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                            Langgan
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-700">
                <p class="text-gray-400 text-center">&copy; {{ date('Y') }} OFYS - Outdoor Untuk Jiwa Anda. Hak cipta terpelihara.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
