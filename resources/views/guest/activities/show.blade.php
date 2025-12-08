<x-app-layout>
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex items-center space-x-2 text-sm font-medium text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-gray-700">{{ __('Home') }}</a>
                    <span class="text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                    <a href="{{ route('activities.index') }}" class="hover:text-gray-700">{{ __('Activities') }}</a>
                    <span class="text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                    <span class="text-gray-900">{{ $activity->name }}</span>
                </nav>
            </div>

            <!-- Activity Details -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Image Gallery -->
                <div class="relative">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                        <div class="md:col-span-2 h-72 md:h-96 overflow-hidden rounded-lg">
                            @if($activity->images && is_array($activity->images) && count($activity->images) > 0)
                                <img
                                    src="{{ storage_url($activity->images[0]) }}"
                                    alt="{{ $activity->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">{{ __('No image available') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4 h-72 md:h-96">
                            @if($activity->images && is_array($activity->images) && count($activity->images) > 1)
                                @foreach(array_slice($activity->images, 1, 4) as $index => $image)
                                    <div class="overflow-hidden rounded-lg">
                                        <img
                                            src="{{ storage_url($image) }}"
                                            alt="{{ $activity->name }} - image {{ $index + 2 }}"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                @endforeach
                            @endif

                            @for($i = count($activity->images ?? []) - 1; $i < 4; $i++)
                                <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">{{ __('No Image') }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Info -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-medium uppercase">
                                        {{ $activityTypes[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                                    </span>
                                    @if(!$activity->is_active)
                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium uppercase ml-2">
                                            {{ __('Not Available') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center text-yellow-500">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-gray-600 ml-2 text-sm">(4.0)</span>
                                </div>
                            </div>

                            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ $activity->name }}</h1>

                            <div class="flex items-center mt-2 text-gray-600">
                                <svg class="h-5 w-5 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $activity->location }}</span>
                            </div>

                            <div class="flex items-center mt-1 text-gray-600">
                                <svg class="h-5 w-5 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <span>
                                    @if($activity->shopInfo && $activity->shopInfo->company_name)
                                        {{ __('Hosted by') }} {{ $activity->shopInfo->company_name }}
                                    @elseif($activity->shopInfo && $activity->shopInfo->user)
                                        {{ __('Hosted by') }} {{ $activity->shopInfo->user->name }}
                                    @else
                                        {{ __('Hosted by') }} OFYS
                                    @endif
                                </span>
                            </div>

                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Description') }}</h2>
                                <div class="prose max-w-none text-gray-600">
                                    {!! nl2br(e($activity->description)) !!}
                                </div>
                            </div>

                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('What to expect') }}</h2>
                                <div class="prose max-w-none text-gray-600">
                                    {!! nl2br(e($activity->what_to_expect)) !!}
                                </div>
                            </div>

                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Additional Information') }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ __('Duration') }}</h3>
                                            <p class="text-sm text-gray-600">
                                                @if(isset($activity->duration_minutes))
                                                    {{ floor($activity->duration_minutes / 60) }} {{ __('hrs') }}
                                                    @if($activity->duration_minutes % 60 > 0)
                                                        {{ $activity->duration_minutes % 60 }} {{ __('mins') }}
                                                    @endif
                                                @else
                                                    {{ __('Duration not specified') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ __('Pricing') }}</h3>
                                            <p class="text-sm text-gray-600">RM{{ number_format($activity->price, 2) }} / {{ $activity->getPriceTypeFormattedAttribute() }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ __('Group Size') }}</h3>
                                            <p class="text-sm text-gray-600">{{ __('Up to') }} {{ $activity->max_participants }} {{ __('participants') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="h-6 w-6 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ __('Safety Guidelines') }}</h3>
                                            <p class="text-sm text-gray-600">{{ $activity->safety_guidelines ?: __('None provided') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Location') }}</h2>
                                <div class="bg-gray-100 rounded-lg p-4">
                                    <p class="text-gray-600">{{ $activity->location }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ __('Exact location details will be provided after booking.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Card -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg shadow-md p-6 sticky top-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Book This Activity') }}</h2>

                                <div class="bg-white rounded-md shadow-sm p-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">{{ __('Price') }}</span>
                                        <span class="text-gray-900 font-bold">RM{{ number_format($activity->price, 2) }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ __('Per') }} {{ $activity->getPriceTypeFormattedAttribute() }}</div>
                                </div>

                                @if($activity->is_active)
                                    <a href="{{ route('customer.bookings.create', $activity->id) }}" class="block w-full bg-yellow-500 text-white text-center font-medium py-3 rounded-md hover:bg-yellow-600 transition">
                                        {{ __('Book Now') }}
                                    </a>
                                @else
                                    <button disabled class="block w-full bg-gray-300 text-gray-500 text-center font-medium py-3 rounded-md cursor-not-allowed">
                                        {{ __('Currently Unavailable') }}
                                    </button>
                                @endif

                                <div class="text-xs text-gray-500 text-center mt-4">
                                    {{ __('You won\'t be charged yet') }}
                                </div>

                                <div class="mt-6 flex items-center justify-center">
                                    <button class="flex items-center text-gray-600 hover:text-yellow-500 text-sm font-medium">
                                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        {{ __('Share this activity') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
