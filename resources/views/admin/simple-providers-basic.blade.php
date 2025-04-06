@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto">
    <!-- Header with title -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Providers Management</h1>
            <p class="mt-1 text-gray-600">Manage all provider accounts on the platform</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.providers.edit', 'new') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-white tracking-wide hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 transition ease-in-out duration-150">
                <i class="fas fa-plus-circle mr-2"></i>
                New Provider
            </a>
        </div>
    </div>

    <!-- Flash messages -->
    @if (session()->has('success'))
        <div id="success-message" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div id="error-message" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Card container for the table and filters -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Top section with filters -->
        <div class="p-6 border-b border-gray-200">
            <form id="searchForm" action="{{ route('admin.simple-providers-basic') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="search" id="search" name="search" value="{{ request('search') }}" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md" placeholder="Search providers...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-48">
                    <label for="status" class="sr-only">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    </select>
                </div>

                <!-- Submit and Reset buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                    <button id="resetFilters" type="button" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-undo mr-2"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Table section -->
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Provider
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created On
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($providers as $provider)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($provider->profile_image)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                                                        {{ substr($provider->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $provider->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $provider->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $provider->username ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(isset($provider->status))
                                            @if($provider->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Active
                                                </span>
                                            @elseif($provider->status === 'inactive')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                                </span>
                                            @elseif($provider->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-question-circle mr-1"></i>{{ $provider->status }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($provider->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.providers.view', $provider->id) }}" class="flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md transition duration-150 ease-in-out">
                                                <i class="fas fa-eye mr-1"></i>
                                                View
                                            </a>
                                            <a href="{{ route('admin.providers.edit', $provider->id) }}" class="flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-md transition duration-150 ease-in-out">
                                                <i class="fas fa-pencil-alt mr-1"></i>
                                                Edit
                                            </a>
                                            <button data-id="{{ $provider->id }}" data-name="{{ $provider->name }}" class="delete-provider flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition duration-150 ease-in-out">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No providers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($providers->count() > 0)
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $providers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-submit the form when a filter changes
        $('#status').on('change', function() {
            $('#searchForm').submit();
        });

        // Reset filters button
        $('#resetFilters').on('click', function() {
            $('#search').val('');
            $('#status').val('');
            $('#searchForm').submit();
        });

        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);

        // Delete provider modal
        $('.delete-provider').on('click', function() {
            const providerId = $(this).data('id');
            const providerName = $(this).data('name');

            // Update the modal content and data attributes
            $('#providerToDeleteName').text(providerName);
            $('#confirmDeleteBtn').data('id', providerId);

            // Show the delete confirmation modal
            $('#deleteConfirmationModal').removeClass('hidden');
        });

        // Close delete confirmation modal
        $('#cancelDeleteBtn, #deleteConfirmationModal .bg-gray-500').on('click', function(e) {
            if (e.target === this || e.target.id === 'cancelDeleteBtn') {
                $('#deleteConfirmationModal').addClass('hidden');
            }
        });

        // Confirm delete action
        $('#confirmDeleteBtn').on('click', function() {
            const providerId = $(this).data('id');

            // Show loading state on button
            const $button = $(this);
            const originalText = $button.html();
            $button.html('<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...').prop('disabled', true);

            // Send delete request to the API
            $.ajax({
                url: `/api/providers/${providerId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Hide modal
                        $('#deleteConfirmationModal').addClass('hidden');

                        // Show success message
                        const successMessage = `
                            <div id="success-message" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <p>Provider deleted successfully.</p>
                                </div>
                            </div>
                        `;

                        // Insert the success message at the top of the content area
                        if ($('#success-message').length) {
                            $('#success-message').remove();
                        }
                        $('.mb-6.flex').after(successMessage);

                        // Reload the page after a short delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Reset button
                        $button.html(originalText).prop('disabled', false);

                        // Hide modal and show error
                        $('#deleteConfirmationModal').addClass('hidden');
                        alert('Error deleting provider: ' + response.message);
                    }
                },
                error: function(error) {
                    // Reset button
                    $button.html(originalText).prop('disabled', false);

                    // Hide modal and show error
                    $('#deleteConfirmationModal').addClass('hidden');
                    console.error('Error deleting provider:', error);
                    alert('Error deleting provider. Please try again.');
                }
            });
        });
    });
</script>
@endsection

@section('modals')
<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Provider</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this provider? <span id="providerToDeleteName" class="font-medium"></span>
                                <br><br>
                                This action cannot be undone. All provider data, including shop information and activities will be permanently removed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmDeleteBtn" data-id="" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
                <button type="button" id="cancelDeleteBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
