@extends('layouts.provider.simple-app')

@section('header', 'Activities & Services')

@section('breadcrumbs')
    @include('layouts.partials.breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('provider.dashboard')],
            ['label' => 'Activities & Services'],
        ],
    ])
@endsection

@section('header_subtitle')
    Manage every offering, pricing update, and availability from a single view.
@endsection

@section('header_actions')
    <div class="flex space-x-3">
        <a href="{{ route('provider.activities.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Activity
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div id="success-message" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between space-y-3 md:space-y-0">
                <div class="relative flex-1 max-w-xs">
                    <input type="text" id="search-term"
                        class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Search activities...">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex space-x-2">
                    <select id="filter-activity-type"
                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500">
                        <option value="">All Activity Types</option>
                        @foreach($activityTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name & Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pricing
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Participants
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                    <tr class="activity-row" data-activity-type="{{ $activity->activity_type }}" data-activity-name="{{ strtolower($activity->name) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $activity->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $activityTypes[$activity->activity_type] ?? $activity->activity_type }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">RM {{ number_format($activity->price, 2) }}</div>
                            <div class="text-sm text-gray-500">
                                @if($activity->price_type == 'per_person')
                                    Per Person
                                @elseif($activity->price_type == 'per_hour')
                                    Per Hour
                                @elseif($activity->price_type == 'fixed')
                                    Fixed Price
                                @else
                                    {{ $activity->price_type }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                Min: {{ $activity->min_participants }}
                                @if($activity->max_participants)
                                    <span class="text-gray-500">|</span> Max: {{ $activity->max_participants }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                @if($activity->duration_minutes)
                                    {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                @else
                                    Duration not specified
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $activity->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('provider.activities.view', $activity->id) }}" class="text-teal-600 hover:text-teal-900 mr-3">
                                View
                            </a>
                            <a href="{{ route('provider.activities.edit', $activity->id) }}" class="text-teal-600 hover:text-teal-900 mr-3">
                                Edit
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-900 delete-activity" data-activity-id="{{ $activity->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr id="no-activities-row">
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No activities found. Click "Add New Activity" to create your first activity.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $activities->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @include('provider.partials.modal', [
        'id' => 'delete-confirmation-modal',
        'title' => 'Delete Activity',
        'modalClass' => 'sm:max-w-md',
        'showFooter' => true
    ])

    <div id="delete-confirmation-modal-content" class="hidden">
        <div class="p-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this activity? This action cannot be undone.
                </p>
            </div>
        </div>

        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 border-t border-gray-200">
            <form id="delete-activity-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
            </form>
            <button type="button" onclick="hideModal('delete-confirmation-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-hide success message after 3 seconds
        setTimeout(function() {
            $('#success-message').fadeOut('slow');
        }, 3000);

        // Search functionality
        $('#search-term').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            filterActivities();
        });

        // Activity type filter
        $('#filter-activity-type').on('change', function() {
            filterActivities();
        });

        // Move the modal content to the modal
        var modalContent = $('#delete-confirmation-modal-content').html();
        $('#delete-confirmation-modal .modal-content').html(modalContent);
        $('#delete-confirmation-modal-content').remove();

        // Delete activity
        $('.delete-activity').on('click', function() {
            var activityId = $(this).data('activity-id');
            $('#delete-activity-form').attr('action', '{{ route('provider.activities.delete', '') }}/' + activityId);

            // Pre-select the clicked activity row
            window.activityRowToRemove = $(this).closest('tr');

            // Show the confirmation modal
            showModal('delete-confirmation-modal');
        });

        // Handle delete form submission with AJAX
        $('#delete-activity-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: 'DELETE',
                url: url,
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        // Hide the modal
                        hideModal('delete-confirmation-modal');

                        // Remove the row from the table
                        if (window.activityRowToRemove) {
                            window.activityRowToRemove.remove();
                            window.activityRowToRemove = null;
                        }

                        // Show success message
                        $('<div id="ajax-success-message" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700"><div class="flex items-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><p>' + response.message + '</p></div></div>')
                            .insertBefore('.bg-white.rounded-lg.shadow-sm');

                        // Auto-hide the success message after 3 seconds
                        setTimeout(function() {
                            $('#ajax-success-message').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }, 3000);

                        // If no more activities, show the empty message
                        if ($('.activity-row:visible').length === 0) {
                            if ($('#no-activities-row').length) {
                                $('#no-activities-row').show();
                            } else {
                                $('<tr id="no-activities-row"><td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No activities found. Click "Add New Activity" to create your first activity.</td></tr>').appendTo('tbody');
                            }
                        }
                    }
                },
                error: function(xhr) {
                    hideModal('delete-confirmation-modal');

                    // Show error message
                    var errorMessage = 'An error occurred while deleting the activity.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    $('<div id="ajax-error-message" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700"><div class="flex items-center"><svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg><p>' + errorMessage + '</p></div></div>')
                        .insertBefore('.bg-white.rounded-lg.shadow-sm');

                    // Auto-hide the error message after 5 seconds
                    setTimeout(function() {
                        $('#ajax-error-message').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            });
        });

        // Function to filter activities
        function filterActivities() {
            var searchTerm = $('#search-term').val().toLowerCase();
            var activityType = $('#filter-activity-type').val();
            var foundResults = false;

            $('.activity-row').each(function() {
                var rowActivityType = $(this).data('activity-type');
                var rowActivityName = $(this).data('activity-name');
                var typeMatch = !activityType || rowActivityType === activityType;
                var searchMatch = !searchTerm || rowActivityName.includes(searchTerm);

                if (typeMatch && searchMatch) {
                    $(this).show();
                    foundResults = true;
                } else {
                    $(this).hide();
                }
            });

            // Show/hide no results message
            if (foundResults) {
                if ($('#no-activities-row').length) {
                    $('#no-activities-row').hide();
                }
            } else {
                if ($('#no-activities-row').length) {
                    $('#no-activities-row').show();
                } else {
                    $('<tr id="no-activities-row"><td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No matching activities found.</td></tr>').appendTo('tbody');
                }
            }
        }
    });
</script>
@endpush
