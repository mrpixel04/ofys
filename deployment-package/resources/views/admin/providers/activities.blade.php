<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Activity Management</h1>
            <p class="text-lg text-gray-600">View all activities created by providers on your platform.</p>
        </div>

        <!-- Livewire Component for Provider Activities -->
        @livewire('admin.provider-activities-list')
    </div>
</x-admin-layout>
