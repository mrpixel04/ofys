<x-app-layout>
    <!-- Activities List with Filters -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Activity List Title -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Browse Activities</h1>
                <p class="mt-2 text-gray-600">Discover and book amazing outdoor activities, workshops, and adventures.</p>
            </div>

            @livewire('home-activities')
        </div>
    </div>
</x-app-layout>
