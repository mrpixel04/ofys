<!-- Activities Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($activities as $activity)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-teal-100">
            @php($coverImage = $activity->cover_image_url)
            @if($coverImage)
                <img src="{{ $coverImage }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-teal-50 flex items-center justify-center text-teal-400">
                    <span class="text-sm font-medium">No Image Available</span>
                </div>
            @endif

            <div class="p-5 space-y-4">
                <div class="space-y-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $activity->name }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-2">{{ \Illuminate\Support\Str::limit($activity->description, 110) }}</p>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="inline-flex items-center text-gray-500">
                        <svg class="h-4 w-4 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $activity->location ?? 'Location TBD' }}
                    </span>
                    <span class="inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700 uppercase tracking-wide">{{ str_replace('_', ' ', $activity->activity_type) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-teal-600">RM {{ number_format($activity->price, 2) }}</span>
                    <a href="{{ route('activities.show', $activity->id) }}"
                       class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-1">
                        View Details
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
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
