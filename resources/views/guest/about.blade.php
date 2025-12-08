<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gray-900">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1464207687429-7505649dae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Mountain view">
            <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ __('About Us') }}</h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">{{ __('Providing unforgettable outdoor experiences for every adventurer.') }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-16">
                <!-- Vision & Mission -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Vision & Mission') }}</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-yellow-50 p-8 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Vision') }}</h3>
                            <p class="text-gray-600">{{ __('To become the leading platform for outdoor activities in Malaysia, connecting adventurers with authentic and unforgettable experiences.') }}</p>
                        </div>
                        <div class="bg-yellow-50 p-8 rounded-lg">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Mission') }}</h3>
                            <p class="text-gray-600">{{ __('To provide easy access to a variety of quality outdoor activities, while promoting sustainable tourism and supporting local communities.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Our Story -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Our Story') }}</h2>
                    <div class="prose prose-lg max-w-none text-gray-600">
                        <p>{{ __('OFYS (Outdoor For Your Soul) started from a dream to make outdoor activities more accessible to everyone. We believe that everyone should have the opportunity to experience the wonders of Malaysia\'s natural beauty.') }}</p>
                        <p class="mt-4">{{ __('Since our establishment, we have partnered with the best activity providers across the country to offer unforgettable experiences. From mountain climbing to snorkeling at beautiful islands, we ensure every adventure is safe, fun, and meaningful.') }}</p>
                    </div>
                </div>

                <!-- Our Values -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Our Values') }}</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="text-yellow-500 mb-4">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('Quality') }}</h3>
                            <p class="text-gray-600">{{ __('We are committed to providing high-quality experiences with carefully selected providers.') }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="text-yellow-500 mb-4">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('Safety') }}</h3>
                            <p class="text-gray-600">{{ __('Safety is our priority. Every activity complies with strict safety standards.') }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="text-yellow-500 mb-4">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('Sustainability') }}</h3>
                            <p class="text-gray-600">{{ __('We promote sustainable tourism and support nature conservation efforts.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
