<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gray-900">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Customer service team">
            <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ __('Contact Us') }}</h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">{{ __('We are always ready to help you plan your next adventure. Feel free to contact us for any inquiries.') }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-16">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('How to Contact Us') }}</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Email Contact -->
                        <div class="bg-yellow-50 p-8 rounded-lg">
                            <div class="flex items-center mb-6">
                                <div class="text-yellow-500">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 ml-4">{{ __('Email') }}</h3>
                            </div>
                            <p class="text-gray-600 mb-4">{{ __('Send us an email for any inquiries. We will respond within 24 hours on business days.') }}</p>
                            <a href="mailto:customer.service@ofys.com" class="text-yellow-500 hover:text-yellow-600 font-medium flex items-center">
                                customer.service@ofys.com
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        <!-- WhatsApp Contact -->
                        <div class="bg-yellow-50 p-8 rounded-lg">
                            <div class="flex items-center mb-6">
                                <div class="text-yellow-500">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 ml-4">WhatsApp</h3>
                            </div>
                            <p class="text-gray-600 mb-4">{{ __('Get instant response via WhatsApp. Our operating hours are from 9:00 AM to 6:00 PM, Monday to Friday.') }}</p>
                            <a href="https://wa.me/60125678907" class="text-yellow-500 hover:text-yellow-600 font-medium flex items-center">
                                +60 12-567 8907
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Our Commitment') }}</h2>
                    <div class="prose prose-lg max-w-none text-gray-600">
                        <p>{{ __('At OFYS, customer satisfaction is our priority. Our dedicated customer service team is always ready to help you with any inquiries, booking suggestions, or feedback. We take pride in providing excellent customer service and ensuring every interaction with us is positive and helpful.') }}</p>
                        <p class="mt-4">{{ __('Whether you need help choosing the right activity, have questions about bookings, or want to share your experience, we are always listening. Your feedback helps us continue to improve our services and experiences for all OFYS travelers.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
