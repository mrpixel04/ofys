<x-app-layout>
    <!-- Hero Section with Animated Text and Rotating Images -->
    <div class="relative bg-gray-900 overflow-hidden" style="height: 550px;">
        <div class="max-w-7xl mx-auto h-full">
            <div class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-1/2 lg:pb-28 xl:pb-32 h-full flex items-center">
                <div class="relative pt-6 px-4 sm:px-6 lg:px-8"></div>
                <main class="mx-auto w-full px-4 sm:px-6 lg:px-8">
                    <div class="sm:text-center lg:text-left">
                        <!-- Animated Title -->
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline hero-text-slide-up opacity-0" style="animation-delay: 0.2s">Welcome to</span>
                            <span class="block text-yellow-500 xl:inline hero-text-slide-up opacity-0" style="animation-delay: 0.4s">OFYS</span>
                        </h1>

                        <!-- Auto-Rotating Marketing Subtitle -->
                        <div class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 hero-text-fade-in opacity-0 relative" style="animation-delay: 0.6s; min-height: 80px;">
                            <p class="marketing-text absolute inset-0 transition-all duration-1000 active">
                                Discover amazing local adventures and experiences in Malaysia. Connect with nature, culture, and community through our curated outdoor activities.
                            </p>
                            <p class="marketing-text absolute inset-0 transition-all duration-1000 opacity-0">
                                From Langkawi's beaches to Cameron Highlands' tea plantations - explore Malaysia's hidden gems with trusted local providers and unforgettable experiences.
                            </p>
                            <p class="marketing-text absolute inset-0 transition-all duration-1000 opacity-0">
                                Book authentic Malaysian outdoor adventures - jungle trekking, island hopping, cultural tours, and eco-camping. Your next adventure starts here!
                            </p>
                            <p class="marketing-text absolute inset-0 transition-all duration-1000 opacity-0">
                                Join thousands of adventurers discovering Malaysia's natural wonders. Safe, verified activities from passionate local experts across the nation.
                            </p>
                        </div>

                        <!-- Animated Stats/Features -->
                        <div class="mt-8 flex flex-wrap gap-6 sm:justify-center lg:justify-start hero-stats-appear opacity-0" style="animation-delay: 0.8s">
                            <div class="flex items-center space-x-2">
                                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center pulse-scale">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-white counter" data-target="50">0</p>
                                    <p class="text-sm text-gray-400">Destinations</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center pulse-scale" style="animation-delay: 0.2s">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-white counter" data-target="100">0</p>
                                    <p class="text-sm text-gray-400">Activities</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center pulse-scale" style="animation-delay: 0.4s">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-white counter" data-target="500">0</p>
                                    <p class="text-sm text-gray-400">Happy Customers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Rotating Images Section -->
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 relative">
            @php
                $heroImages = [
                    [
                        'url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1200&h=800&fit=crop&q=80',
                        'alt' => 'Hiking Adventure',
                        'title' => 'Hiking'
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=1200&h=800&fit=crop&q=80',
                        'alt' => 'Camping Under Stars',
                        'title' => 'Camping'
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1200&h=800&fit=crop&q=80',
                        'alt' => 'Glamping Experience',
                        'title' => 'Glamping'
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1200&h=800&fit=crop&q=80',
                        'alt' => 'Kayaking Adventure',
                        'title' => 'Kayaking'
                    ],
                    [
                        'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=800&fit=crop&q=80',
                        'alt' => 'Mountain Climbing',
                        'title' => 'Climbing'
                    ]
                ];
            @endphp

            @foreach($heroImages as $index => $image)
                <div class="hero-image absolute inset-0 {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                         src="{{ $image['url'] }}"
                         alt="{{ $image['alt'] }}">
                    <div class="absolute inset-0 bg-gradient-to-l from-transparent to-gray-900/50"></div>

                    <!-- Activity Label -->
                    <div class="absolute bottom-8 right-8 bg-yellow-500 text-gray-900 px-6 py-3 rounded-full font-bold text-lg shadow-2xl transform transition-all duration-500 activity-label">
                        {{ $image['title'] }}
                    </div>
                </div>
            @endforeach

            <!-- Image Navigation Dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                @foreach($heroImages as $index => $image)
                    <button class="hero-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-yellow-500 w-8' : 'bg-white/50 hover:bg-white/80' }}"
                            data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        /* Text Animations */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes statsAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseScale {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .hero-text-slide-up {
            animation: slideUpFade 0.8s ease-out forwards;
        }

        .hero-text-fade-in {
            animation: fadeInScale 1s ease-out forwards;
        }

        .hero-stats-appear {
            animation: statsAppear 1s ease-out forwards;
        }

        .pulse-scale {
            animation: pulseScale 2s ease-in-out infinite;
        }

        /* Image Rotation Animations */
        .hero-image {
            opacity: 0;
            transition: opacity 2s ease-in-out;
            pointer-events: none;
        }

        .hero-image.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Different animation styles for each image */
        .hero-image[data-index="0"].active {
            animation: fadeIn 2s ease-in-out;
        }

        .hero-image[data-index="1"].active {
            animation: zoomIn 2s ease-in-out;
        }

        .hero-image[data-index="2"].active {
            animation: slideFromRight 2s ease-in-out;
        }

        .hero-image[data-index="3"].active {
            animation: fadeInRotate 2s ease-in-out;
        }

        .hero-image[data-index="4"].active {
            animation: scaleUp 2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(1.2);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideFromRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRotate {
            from {
                opacity: 0;
                transform: rotate(-5deg) scale(1.1);
            }
            to {
                opacity: 1;
                transform: rotate(0) scale(1);
            }
        }

        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .activity-label {
            animation: labelSlide 0.5s ease-out 0.5s backwards;
        }

        @keyframes labelSlide {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter Animation
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current) + '+';
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target + '+';
                    }
                };

                setTimeout(() => {
                    updateCounter();
                }, 1000);
            });

            // Marketing Text Rotation (5-6 seconds)
            const marketingTexts = document.querySelectorAll('.marketing-text');
            let currentTextIndex = 0;

            function rotateMarketingText() {
                // Fade out current text
                marketingTexts[currentTextIndex].classList.remove('active');
                marketingTexts[currentTextIndex].classList.add('opacity-0');

                // Move to next text
                currentTextIndex = (currentTextIndex + 1) % marketingTexts.length;

                // Fade in next text
                setTimeout(() => {
                    marketingTexts[currentTextIndex].classList.remove('opacity-0');
                    marketingTexts[currentTextIndex].classList.add('active');
                }, 300);
            }

            // Auto-rotate marketing text every 5.5 seconds
            setInterval(rotateMarketingText, 5500);

            // Image Rotation
            const images = document.querySelectorAll('.hero-image');
            const dots = document.querySelectorAll('.hero-dot');
            let currentIndex = 0;
            let interval;

            function showImage(index) {
                images.forEach((img, i) => {
                    img.classList.remove('active');
                    dots[i].classList.remove('bg-yellow-500', 'w-8');
                    dots[i].classList.add('bg-white/50');
                });

                images[index].classList.add('active');
                dots[index].classList.remove('bg-white/50');
                dots[index].classList.add('bg-yellow-500', 'w-8');
                currentIndex = index;
            }

            function nextImage() {
                const next = (currentIndex + 1) % images.length;
                showImage(next);
            }

            // Auto-rotate every 10 seconds
            interval = setInterval(nextImage, 10000);

            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    clearInterval(interval);
                    showImage(index);
                    interval = setInterval(nextImage, 10000);
                });
            });
        });
    </script>

    <!-- Search Filter Section -->
    <div class="relative -mt-12 sm:-mt-16 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                <form action="{{ route('activities.index') }}" method="GET" id="search-activities-form" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Activity</label>
                        <input type="text" id="search" name="search" placeholder="What would you like to do?"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" id="location" name="location" placeholder="Where?"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Activity Type</label>
                        <select id="type" name="type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Any Type</option>
                            @foreach(App\Models\Activity::getActivityTypes() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="price_range" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                        <div class="flex space-x-2">
                            <input type="number" id="min_price" name="min_price" placeholder="Min" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            <input type="number" id="max_price" name="max_price" placeholder="Max" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Activities Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900">Featured Activities</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Explore our most popular outdoor adventures</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="featured-activities">
                @php
                    $activities = App\Models\Activity::with('shopInfo')
                        ->where('is_active', true)
                        ->orderBy('created_at', 'desc')
                        ->take(8)
                        ->get();
                @endphp

                @foreach($activities as $activity)
                    <div class="bg-white rounded-lg shadow overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="h-48 w-full relative">
                            @if($activity->images && count($activity->images) > 0)
                                <img src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    <span>No Image</span>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 m-2 px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded">
                                {{ \App\Models\Activity::getActivityTypes()[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $activity->name }}</h3>
                            <p class="text-gray-500 text-sm mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $activity->location }}
                            </p>
                            <p class="text-gray-700 text-sm mb-3 line-clamp-2">{{ Str::limit($activity->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-yellow-600 font-bold">RM {{ number_format($activity->price, 2) }}</span>
                                <a href="{{ route('activities.show', $activity->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('activities.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 transition duration-150 ease-in-out">
                    View All Activities <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-yellow-500 font-semibold tracking-wide uppercase">Our Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Experience Malaysia Like Never Before
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    OFYS provides curated outdoor experiences that connect you with Malaysia's natural beauty, rich culture, and local communities.
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Diverse Experiences</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            From jungle trekking to cultural immersions, OFYS offers a wide range of activities for every adventurer.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Expert Local Guides</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            All our activities are led by experienced local guides who are passionate about sharing their knowledge and culture.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Easy Booking</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Simple, secure booking process with flexible options to suit your schedule and preferences.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Popular Locations Section with Auto-Scrolling Carousel -->
    <div class="py-16 bg-gradient-to-b from-white to-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="text-center">
                <h2 class="text-base text-yellow-500 font-semibold tracking-wide uppercase">Discover Malaysia</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Popular Destinations
                </p>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Explore breathtaking activities in Malaysia's most stunning locations
                </p>
            </div>
        </div>

        <!-- Auto-Scrolling Carousel Container -->
        <div class="relative">
            <!-- Gradient Overlays for fade effect -->
            <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

            <!-- Scrolling Container -->
            <div class="locations-carousel flex gap-6 py-4" id="locations-carousel">
                @php
                    $destinations = [
                        [
                            'name' => 'Langkawi',
                            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800&h=600&fit=crop&q=80',
                            'description' => 'Tropical Paradise'
                        ],
                        [
                            'name' => 'Penang',
                            'image' => 'https://images.unsplash.com/photo-1598963757243-e8d52e8c6f2d?w=800&h=600&fit=crop&q=80',
                            'description' => 'Heritage & Culture'
                        ],
                        [
                            'name' => 'Cameron Highlands',
                            'image' => 'https://images.unsplash.com/photo-1563789031959-4c02bcb41319?w=800&h=600&fit=crop&q=80',
                            'description' => 'Tea Plantations'
                        ],
                        [
                            'name' => 'Kuala Lumpur',
                            'image' => 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=800&h=600&fit=crop&q=80',
                            'description' => 'Urban Adventures'
                        ],
                        [
                            'name' => 'Sabah',
                            'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&h=600&fit=crop&q=80',
                            'description' => 'Mount Kinabalu'
                        ],
                        [
                            'name' => 'Melaka',
                            'image' => 'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=800&h=600&fit=crop&q=80',
                            'description' => 'Historic City'
                        ],
                        [
                            'name' => 'Perhentian Islands',
                            'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=600&fit=crop&q=80',
                            'description' => 'Crystal Clear Waters'
                        ],
                        [
                            'name' => 'Taman Negara',
                            'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop&q=80',
                            'description' => 'Rainforest Trek'
                        ]
                    ];
                @endphp

                @foreach($destinations as $destination)
                    <a href="{{ route('activities.index', ['location' => $destination['name']]) }}"
                       class="location-card flex-shrink-0 w-80 h-96 relative rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:scale-105 group">
                        <!-- Background Image with Parallax -->
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                             style="background-image: url('{{ $destination['image'] }}');">
                        </div>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-70 group-hover:opacity-80 transition-opacity duration-300"></div>

                        <!-- Content -->
                        <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                            <div class="transform transition-transform duration-300 group-hover:translate-y-0 translate-y-2">
                                <p class="text-sm font-medium text-yellow-400 mb-2">{{ $destination['description'] }}</p>
                                <h3 class="text-3xl font-bold mb-2">{{ $destination['name'] }}</h3>
                                <div class="flex items-center text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="mr-2">Explore Activities</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Corner Accent -->
                        <div class="absolute top-4 right-4 w-12 h-12 border-t-2 border-r-2 border-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                @endforeach

                <!-- Duplicate cards for seamless loop -->
                @foreach($destinations as $destination)
                    <a href="{{ route('activities.index', ['location' => $destination['name']]) }}"
                       class="location-card flex-shrink-0 w-80 h-96 relative rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:scale-105 group">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                             style="background-image: url('{{ $destination['image'] }}');">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-70 group-hover:opacity-80 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">
                            <div class="transform transition-transform duration-300 group-hover:translate-y-0 translate-y-2">
                                <p class="text-sm font-medium text-yellow-400 mb-2">{{ $destination['description'] }}</p>
                                <h3 class="text-3xl font-bold mb-2">{{ $destination['name'] }}</h3>
                                <div class="flex items-center text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="mr-2">Explore Activities</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4 w-12 h-12 border-t-2 border-r-2 border-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Navigation Dots (Optional) -->
        <div class="flex justify-center mt-8 gap-2">
            @for($i = 0; $i < 8; $i++)
                <div class="w-2 h-2 rounded-full bg-gray-300 hover:bg-yellow-500 transition-colors duration-300 cursor-pointer location-dot" data-index="{{ $i }}"></div>
            @endfor
        </div>
    </div>

    <style>
        .locations-carousel {
            animation: scroll 40s linear infinite;
            will-change: transform;
        }

        .locations-carousel:hover {
            animation-play-state: paused;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-384px * 8 - 1.5rem * 8));
            }
        }

        .location-card {
            cursor: pointer;
        }

        /* Smooth parallax effect on scroll */
        @media (prefers-reduced-motion: no-preference) {
            .location-card {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
        }
    </style>

    <!-- Add JavaScript for search form enhancement -->
    <!-- Ensure jQuery is available on this page for the search/filter UX -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Initialize form with any URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.has('search')) $('#search').val(urlParams.get('search'));
            if(urlParams.has('location')) $('#location').val(urlParams.get('location'));
            if(urlParams.has('type')) $('#type').val(urlParams.get('type'));
            if(urlParams.has('min_price')) $('#min_price').val(urlParams.get('min_price'));
            if(urlParams.has('max_price')) $('#max_price').val(urlParams.get('max_price'));

            // Function to handle instant search by filtering the existing activities
            function performInstantSearch() {
                const search = $('#search').val().toLowerCase();
                const location = $('#location').val().toLowerCase();
                const type = $('#type').val();
                const minPrice = $('#min_price').val() ? parseFloat($('#min_price').val()) : 0;
                const maxPrice = $('#max_price').val() ? parseFloat($('#max_price').val()) : Number.MAX_SAFE_INTEGER;

                // Show loading state
                $('#featured-activities').addClass('opacity-50');

                // Directly filter existing activities without AJAX
                $('#featured-activities > div').each(function() {
                    const $activity = $(this);
                    const activityName = $activity.find('h3').text().toLowerCase();
                    const activityLocation = $activity.find('.text-gray-500:first').text().toLowerCase();
                    const activityDescription = $activity.find('.text-gray-700').text().toLowerCase();
                    const activityType = $activity.find('.absolute.top-0.right-0 span').text().toLowerCase();
                    const activityPriceText = $activity.find('.text-yellow-600').text().replace('RM', '').replace(',', '').trim();
                    const activityPrice = parseFloat(activityPriceText);

                    // Check if the activity matches all criteria
                    const matchesSearch = !search ||
                        activityName.includes(search) ||
                        activityDescription.includes(search);

                    const matchesLocation = !location ||
                        activityLocation.includes(location);

                    const matchesType = !type ||
                        activityType.toLowerCase().includes(type.toLowerCase());

                    const matchesPrice = (!isNaN(activityPrice)) &&
                        activityPrice >= minPrice &&
                        activityPrice <= maxPrice;

                    // Show or hide based on match
                    if (matchesSearch && matchesLocation && matchesType && matchesPrice) {
                        $activity.removeClass('hidden');
                    } else {
                        $activity.addClass('hidden');
                    }
                });

                // Check if any activities are visible
                const visibleActivities = $('#featured-activities > div:not(.hidden)').length;
                if (visibleActivities === 0) {
                    // If no activities match, show a message
                    if ($('#no-results-message').length === 0) {
                        $('#featured-activities').append(
                            '<div id="no-results-message" class="col-span-full text-center py-8">' +
                            '<p class="text-gray-700">No activities found matching your criteria.</p>' +
                            '<button id="clear-filters" class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">' +
                            'Clear Filters</button>' +
                            '</div>'
                        );

                        // Add event listener to the clear filters button
                        $('#clear-filters').on('click', function() {
                            $('#search, #location').val('');
                            $('#type').val('');
                            $('#min_price, #max_price').val('');
                            performInstantSearch();
                        });
                    }
                } else {
                    // Remove the no results message if it exists
                    $('#no-results-message').remove();
                }

                // Remove loading state
                $('#featured-activities').removeClass('opacity-50');
            }

            // Set up event listeners for instant search
            let searchTimeout;
            $('#search, #location').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performInstantSearch, 300);
            });

            $('#type, #min_price, #max_price').on('change', function() {
                performInstantSearch();
            });

            // Quick links for popular locations
            $('.location-link').click(function(e) {
                e.preventDefault();
                const locationName = $(this).data('location');
                $('#location').val(locationName);
                performInstantSearch();
            });

            // Form validation before submit
            $('#search-activities-form').on('submit', function(e) {
                const minPrice = $('#min_price').val();
                const maxPrice = $('#max_price').val();

                // Validate min price is less than max price if both are provided
                if (minPrice && maxPrice && parseInt(minPrice) > parseInt(maxPrice)) {
                    alert('Minimum price cannot be greater than maximum price');
                    e.preventDefault();
                    return false;
                }

                return true;
            });
        });
    </script>
</x-app-layout>
