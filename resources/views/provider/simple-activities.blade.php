@extends('layouts.provider.simple-app')

@section('header', 'Activities & Services')

@section('header_actions')
    <div class="flex space-x-3">
        <a href="{{ route('provider.activities.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Activity
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div id="success-message" class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700 shadow-sm border border-green-100 flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div id="error-message" class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-700 shadow-sm border border-red-100 flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-700 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Activities</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $activities->total() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-700 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Active Activities</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $activities->where('is_active', true)->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-50 text-amber-700 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pending Activities</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $activities->where('is_active', false)->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <label for="search-term" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="text" id="search-term"
                            class="block w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Search activities...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="filter-activity-type" class="block text-sm font-medium text-gray-700 mb-1">Activity Type</label>
                    <select id="filter-activity-type"
                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Activity Types</option>
                        @foreach($activityTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="filter-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="filter-status"
                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Activities Cards View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @forelse($activities as $activity)
            <div class="activity-card bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition transform hover:shadow-md hover:-translate-y-1"
                 data-activity-type="{{ $activity->activity_type }}"
                 data-activity-name="{{ strtolower($activity->name) }}"
                 data-activity-status="{{ $activity->is_active ? 'active' : 'inactive' }}">

                <div class="h-36 bg-gray-200 relative overflow-hidden">
                    @if(!empty($activity->images) && is_array($activity->images) && count($activity->images) > 0)
                        <img src="{{ Storage::url($activity->images[0]) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full bg-gray-100 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $activity->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $activity->name }}</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            {{ $activityTypes[$activity->activity_type] ?? $activity->activity_type }}
                        </span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">{{ $activity->location ?? 'Location not specified' }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="bg-gray-50 p-2 rounded text-xs">
                            <span class="text-gray-500">Price:</span>
                            <div class="font-medium">RM {{ number_format($activity->price, 2) }}</div>
                            <div class="text-gray-500 text-xs mt-1">
                                @if($activity->price_type == 'per_person')
                                    Per Person
                                @elseif($activity->price_type == 'per_hour')
                                    Per Hour
                                @elseif($activity->price_type == 'fixed')
                                    Fixed Price
                                @elseif($activity->price_type == 'per_site')
                                    Per Site
                                @elseif($activity->price_type == 'per_pack')
                                    Per Pack
                                @else
                                    {{ $activity->price_type }}
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-2 rounded text-xs">
                            <span class="text-gray-500">Participants:</span>
                            <div class="font-medium">
                                Min: {{ $activity->min_participants }}
                                @if($activity->max_participants)
                                    | Max: {{ $activity->max_participants }}
                                @endif
                            </div>
                            <div class="text-gray-500 text-xs mt-1">
                                @if($activity->duration_minutes)
                                    {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                @else
                                    Duration not specified
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between border-t pt-3">
                        <a href="{{ route('provider.activities.view', $activity->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View
                        </a>
                        <a href="{{ route('provider.activities.edit', $activity->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Edit
                        </a>
                        <button type="button" class="text-red-600 hover:text-red-800 text-sm font-medium delete-activity" data-activity-id="{{ $activity->id }}">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="mb-4">No activities found. Click "Add New Activity" to create your first activity.</p>
                <a href="{{ route('provider.activities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Activity
                </a>
            </div>
            @endforelse
        </div>

        @if($activities->hasPages())
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
        @endif

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Activity
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this activity? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form id="delete-activity-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Delete
                            </button>
                        </form>
                        <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide success/error messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500);
            }

            if (errorMessage) {
                errorMessage.style.transition = 'opacity 0.5s ease';
                errorMessage.style.opacity = '0';
                setTimeout(() => errorMessage.remove(), 500);
            }
        }, 5000);

        // Filter functionality
        const searchInput = document.getElementById('search-term');
        const typeFilter = document.getElementById('filter-activity-type');
        const statusFilter = document.getElementById('filter-status');
        const activityCards = document.querySelectorAll('.activity-card');

        function filterActivities() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;
            const selectedStatus = statusFilter.value;
            let visibleCount = 0;

            activityCards.forEach(card => {
                const name = card.getAttribute('data-activity-name');
                const type = card.getAttribute('data-activity-type');
                const status = card.getAttribute('data-activity-status');

                const matchesSearch = !searchTerm || name.includes(searchTerm);
                const matchesType = !selectedType || type === selectedType;
                const matchesStatus = !selectedStatus || status === selectedStatus;

                if (matchesSearch && matchesType && matchesStatus) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Add event listeners for filters
        searchInput.addEventListener('input', filterActivities);
        typeFilter.addEventListener('change', filterActivities);
        statusFilter.addEventListener('change', filterActivities);

        // Delete modal functionality
        const deleteModal = document.getElementById('delete-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const cancelDelete = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-activity-form');
        const deleteButtons = document.querySelectorAll('.delete-activity');

        function showModal() {
            deleteModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideModal() {
            deleteModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Setup delete buttons
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const activityId = this.getAttribute('data-activity-id');
                deleteForm.action = "{{ url('/provider/activities') }}/" + activityId;
                showModal();
            });
        });

        // Cancel delete
        cancelDelete.addEventListener('click', hideModal);

        // Close modal when clicking outside
        modalBackdrop.addEventListener('click', hideModal);

        // Form submission with AJAX
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const url = form.action;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _token: document.querySelector('input[name="_token"]').value,
                    _method: 'DELETE'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideModal();

                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.id = 'success-message';
                    successDiv.className = 'mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700 shadow-sm border border-green-100 flex items-center';
                    successDiv.innerHTML = `
                        <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p>Activity deleted successfully.</p>
                    `;

                    const container = document.querySelector('.max-w-7xl');
                    container.insertBefore(successDiv, container.firstChild);

                    // Auto-hide the success message
                    setTimeout(function() {
                        successDiv.style.transition = 'opacity 0.5s ease';
                        successDiv.style.opacity = '0';
                        setTimeout(() => successDiv.remove(), 500);
                    }, 5000);

                    // Remove the card from the display
                    const activityId = url.split('/').pop();
                    const activityCard = document.querySelector(`.delete-activity[data-activity-id="${activityId}"]`).closest('.activity-card');
                    activityCard.remove();

                    // Reload the page if all activities are deleted
                    if (document.querySelectorAll('.activity-card').length === 0) {
                        window.location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endpush
