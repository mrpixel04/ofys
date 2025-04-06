<x-app-layout>
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

    <!-- Hero Section -->
    <div class="relative bg-gray-900 z-10">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Mount Kinabalu landscape">
            <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Discover Amazing<br><span class="text-yellow-400">Local Adventures</span></h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">Book outdoor activities, workshops, and adventures. No account needed to explore – just search, browse, and discover!</p>

            <!-- Search Form -->
            <div class="mt-10 max-w-xl">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="px-4 py-5 sm:p-6">
                        <form action="{{ route('activities.index') }}" method="GET" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700">What do you want to do?</label>
                                <div class="mt-1">
                                    <input type="text" name="search" id="search" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="Tours, Adventure, Workshops...">
                                </div>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Where?</label>
                                <div class="mt-1">
                                    <input type="text" name="location" id="location" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="City, State, or Region">
                                </div>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">When?</label>
                                <div class="mt-1">
                                    <input type="date" name="date" id="date" class="py-3 px-4 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Search Activities
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-300 text-center">
                    Popular searches:
                    <a href="{{ route('activities.index', ['type' => 'tours']) }}" class="text-white hover:text-yellow-300">Tours</a>,
                    <a href="{{ route('activities.index', ['type' => 'adventure']) }}" class="text-white hover:text-yellow-300">Adventure</a>,
                    <a href="{{ route('activities.index', ['type' => 'workshops']) }}" class="text-white hover:text-yellow-300">Workshops</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Activities -->
    <div class="bg-white py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Featured Activities</h2>
                <a href="{{ route('activities.index') }}" class="inline-flex items-center text-yellow-500 hover:text-yellow-600 font-medium transition-colors">
                    View all
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach($featuredActivities as $activity)
                    <div class="group relative flex flex-col bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <a href="{{ route('activities.show', $activity->id) }}" class="block flex-shrink-0">
                            <div class="relative h-64 w-full overflow-hidden">
                                @if($activity->images && is_array($activity->images) && count($activity->images) > 0)
                                    <img src="{{ storage_url($activity->images[0]) }}"
                                        alt="{{ $activity->name }}"
                                        class="h-full w-full object-cover object-center transform transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="h-full w-full bg-gradient-to-r from-yellow-400 to-yellow-600 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 m-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-500 text-white">
                                        {{ $activityTypes[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                                    </span>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-gray-900 opacity-80"></div>
                            </div>
                        </a>
                        <div class="flex-1 p-5">
                            <div class="mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-yellow-600 transition-colors truncate">
                                    <a href="{{ route('activities.show', $activity->id) }}">
                                        {{ $activity->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $activity->location }}
                                </p>
                            </div>
                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-xl font-bold text-gray-900">RM{{ number_format($activity->price, 2) }}</span>
                                    <span class="ml-1 text-xs text-gray-500">/ {{ $activity->getPriceTypeFormattedAttribute() }}</span>
                                </div>
                                <a href="{{ route('activities.show', $activity->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 transition-colors">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Explore by Category</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Find the perfect outdoor activity for your adventure.
                </p>
            </div>

            <div class="mt-6 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-6">
                @forelse($activityTypes as $type => $label)
                    <!-- Category Card -->
                    <a href="{{ route('activities.index', ['type' => $type]) }}" class="group block mb-6 lg:mb-0">
                        <div class="relative h-80 w-full overflow-hidden rounded-lg bg-white group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                            <img src="{{ asset('images/categories/' . $type . '.jpg') }}?v={{ time() }}" alt="{{ $label }}"
                                 class="h-full w-full object-cover object-center"
                                 onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600/?{{ urlencode($label) }}&' + Date.now();">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h3 class="text-xl font-bold text-white">{{ $label }}</h3>
                                <p class="mt-1 text-sm text-gray-300">Explore activities</p>
                            </div>
                        </div>
                    </a>
                @empty
                    @for($i = 0; $i < 3; $i++)
                        <div class="relative h-80 w-full overflow-hidden rounded-lg bg-gray-200 animate-pulse sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <div class="h-6 bg-gray-300 rounded animate-pulse mb-2 w-32"></div>
                                <div class="h-4 bg-gray-300 rounded animate-pulse w-24"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>

    <!-- Popular Locations -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 mb-8">Popular Locations</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularLocations as $location)
                    <!-- Location Card -->
                    <a href="{{ route('activities.index', ['location' => $location]) }}" class="group hover:opacity-75 transition duration-300">
                        <div class="relative overflow-hidden rounded-lg shadow-md bg-white h-64">
                            <img src="{{ asset('images/locations/' . strtolower($location) . '.jpg') }}?v={{ time() }}" alt="{{ $location }}"
                                 class="h-full w-full object-cover object-center"
                                 onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600/?city,{{ urlencode($location) }}&' + Date.now();">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <h3 class="text-xl font-semibold text-white">{{ $location }}</h3>
                                <p class="text-sm text-gray-200">Explore activities</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">What Our Customers Say</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Real experiences from adventure seekers like you.
                </p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <span class="text-yellow-600 font-bold text-xl">S</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Sarah K.</h3>
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <blockquote class="mt-2 text-gray-600">
                        "Amazing experience with the kayaking tour. The guides were knowledgeable and friendly. Will definitely book again!"
                    </blockquote>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <span class="text-yellow-600 font-bold text-xl">M</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Michael T.</h3>
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="h-5 w-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <blockquote class="mt-2 text-gray-600">
                        "The camping trip was well organized. The site was clean and the equipment provided was top-notch. Looking forward to trying more activities."
                    </blockquote>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <span class="text-yellow-600 font-bold text-xl">L</span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Lisa R.</h3>
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="h-5 w-5 {{ $i < 5 ? 'text-yellow-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <blockquote class="mt-2 text-gray-600">
                        "Booking was incredibly easy and the hiking tour exceeded my expectations. The views were breathtaking and our guide made sure everyone was comfortable and safe."
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-yellow-500">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:py-16 lg:px-8">
            <div class="px-6 py-6 md:py-12 md:px-12 lg:py-16 lg:px-16 xl:flex xl:items-center">
                <div class="xl:w-0 xl:flex-1">
                    <h2 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                        Want adventure updates?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg leading-6 text-yellow-200">
                        Sign up for our newsletter to get the latest on new activities and special offers.
                    </p>
                </div>
                <div class="mt-8 sm:w-full sm:max-w-md xl:mt-0 xl:ml-8">
                    <form class="sm:flex">
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" required class="w-full rounded-md border-white px-5 py-3 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-yellow-700" placeholder="Enter your email">
                        <button type="submit" class="mt-3 flex w-full items-center justify-center rounded-md border border-transparent bg-yellow-600 px-5 py-3 text-base font-medium text-white shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-yellow-700 sm:mt-0 sm:ml-3 sm:w-auto sm:flex-shrink-0">
                            Subscribe
                        </button>
                    </form>
                    <p class="mt-3 text-sm text-yellow-200">
                        We care about your data. Read our <a href="#" class="font-medium text-white underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Close alert handling
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
</x-app-layout>
