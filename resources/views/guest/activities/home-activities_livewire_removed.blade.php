<!-- Activities Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($activities as $activity)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            @if($activity->image)
                <img src="{{ $activity->image }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif

            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $activity->name }}</h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($activity->description, 100) }}</p>

                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-500">{{ $activity->location }}</span>
                    <span class="text-sm font-medium text-blue-600">{{ $activity->activity_type }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-green-600">RM {{ number_format($activity->price, 2) }}</span>
                    <a href="{{ route('activities.show', $activity->id) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                        View Details
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
