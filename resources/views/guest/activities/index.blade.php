<x-app-layout>
    <!-- Activities List with Filters -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Activity List Title -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900">Browse Activities</h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Discover and book amazing outdoor activities, workshops, and adventures.</p>
            </div>

            <!-- Activities Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($activities as $activity)
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
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No activities found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="mt-8">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
