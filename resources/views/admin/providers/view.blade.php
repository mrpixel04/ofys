@extends('layouts.simple-admin')

@section('title', 'Provider Details')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 border-b border-gray-200 pb-5">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Provider Details</h1>
                <p class="mt-1 text-sm text-gray-500">View detailed information about this provider</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.providers.edit', $provider->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Edit Provider
                </a>
                <a href="{{ route('admin.simple-providers-basic') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div id="success-message" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div id="error-message" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Provider Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-purple-600 h-24 flex items-end justify-center">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center border-4 border-white -mb-10 shadow-lg">
                        @if ($provider->profile_image)
                            <img src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}" class="h-full w-full rounded-full object-cover">
                        @else
                            <div class="h-full w-full rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-user text-purple-500 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-6 pt-16 text-center">
                    <h2 class="text-xl font-bold text-gray-900">{{ $provider->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $provider->email }}</p>

                    <div class="mt-4 flex justify-center">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            {{ $provider->status === 'active' ? 'bg-green-100 text-green-800' : ($provider->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($provider->status ?? 'active') }}
                        </span>
                    </div>

                    <div class="mt-5 border-t border-gray-200 pt-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Username</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $provider->username ?? 'Not set' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $provider->phone ?? 'Not provided' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $provider->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="mt-5 bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-base font-medium text-gray-900">Actions</h3>
                </div>
                <div class="border-t border-gray-200 p-5 space-y-3">
                    <a href="{{ route('admin.providers.edit', $provider->id) }}" class="flex items-center text-sm text-amber-600 hover:text-amber-800">
                        <i class="fas fa-pencil-alt w-5 h-5 mr-2"></i>
                        Edit Provider
                    </a>

                    @if(isset($provider->shopInfo->id))
                    <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-store w-5 h-5 mr-2"></i>
                        Manage Activities
                    </a>
                    @endif

                    <button id="delete-provider-btn" data-id="{{ $provider->id }}" data-name="{{ $provider->name }}" class="flex items-center text-sm text-red-600 hover:text-red-800">
                        <i class="fas fa-trash-alt w-5 h-5 mr-2"></i>
                        Delete Provider
                    </button>
                </div>
            </div>
        </div>

        <!-- Provider Information Tabs -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <button id="company-tab" class="tab-btn active-tab w-1/2 py-4 px-1 text-center border-b-2 border-purple-500 font-medium text-sm text-purple-600">
                            <i class="fas fa-building mr-2"></i>
                            Company Information
                        </button>
                        <button id="activity-tab" class="tab-btn w-1/2 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Activities & Services
                        </button>
                    </nav>
                </div>

                <!-- Company Info Content -->
                <div id="company-content" class="tab-content p-6">
                    @if($provider->shopInfo)
                        <div class="space-y-6">
                            <!-- Basic Company Info -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                                    Basic Information
                                </h3>
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Company Name</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->company_name ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Company Email</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->company_email ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Business Type</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->business_type ?? 'Not specified' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Verification Status</h4>
                                        <p class="mt-1">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $provider->shopInfo->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $provider->shopInfo->is_verified ? 'Verified' : 'Not Verified' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($provider->shopInfo->description)
                            <div class="border-t border-gray-200 pt-5">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-align-left text-purple-500 mr-2"></i>
                                    Description
                                </h3>
                                <p class="mt-3 text-sm text-gray-600">{{ $provider->shopInfo->description }}</p>
                            </div>
                            @endif

                            <!-- Contact Information -->
                            <div class="border-t border-gray-200 pt-5">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                    Contact & Location
                                </h3>
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Address</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->address ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">City</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->city ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">State/Province</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->state ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Postal Code</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->postal_code ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Country</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->country ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Company Phone</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $provider->shopInfo->phone ?? 'Not provided' }}</p>
                                    </div>
                                    @if($provider->shopInfo->website)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Website</h4>
                                        <p class="mt-1 text-sm text-gray-900">
                                            <a href="{{ $provider->shopInfo->website }}" target="_blank" class="text-purple-600 hover:text-purple-900">
                                                {{ $provider->shopInfo->website }}
                                                <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                            </a>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Social Media -->
                            @if($provider->shopInfo->facebook || $provider->shopInfo->instagram || $provider->shopInfo->twitter)
                            <div class="border-t border-gray-200 pt-5">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-share-alt text-purple-500 mr-2"></i>
                                    Social Media
                                </h3>
                                <div class="mt-3 flex space-x-4">
                                    @if($provider->shopInfo->facebook)
                                    <a href="{{ $provider->shopInfo->facebook }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <i class="fab fa-facebook-square text-2xl"></i>
                                    </a>
                                    @endif

                                    @if($provider->shopInfo->instagram)
                                    <a href="{{ $provider->shopInfo->instagram }}" target="_blank" class="text-pink-600 hover:text-pink-800">
                                        <i class="fab fa-instagram-square text-2xl"></i>
                                    </a>
                                    @endif

                                    @if($provider->shopInfo->twitter)
                                    <a href="{{ $provider->shopInfo->twitter }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                        <i class="fab fa-twitter-square text-2xl"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-10">
                            <i class="fas fa-store text-gray-300 text-5xl mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-900">No Company Information</h3>
                            <p class="mt-1 text-sm text-gray-500">This provider hasn't set up their company information yet.</p>
                            <div class="mt-5">
                                <a href="{{ route('admin.providers.edit', $provider->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Add Company Information
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Activities Content -->
                <div id="activity-content" class="tab-content p-6 hidden">
                    @if($provider->shopInfo && isset($provider->shopInfo->activities) && count($provider->shopInfo->activities) > 0)
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Activities & Services</h3>
                                <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    View All
                                </a>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                @foreach($provider->shopInfo->activities as $activity)
                                <div class="bg-white overflow-hidden shadow rounded-lg border">
                                    <div class="p-5">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                                <i class="fas fa-calendar-day text-purple-600"></i>
                                            </div>
                                            <div class="ml-5 w-0 flex-1">
                                                <dl>
                                                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $activity->name }}</dt>
                                                    <dd>
                                                        <div class="text-xs text-gray-900">
                                                            {{ $activity->price_formatted ?? '$0' }} · {{ $activity->duration ?? '0' }} min
                                                        </div>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-200 text-right">
                                        <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-900">
                                            View details
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <i class="fas fa-calendar-alt text-gray-300 text-5xl mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-900">No Activities</h3>
                            <p class="mt-1 text-sm text-gray-500">This provider hasn't added any activities or services yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Delete Provider
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete <span id="providerToDeleteName" class="font-semibold"></span>? This action cannot be undone, and all associated data will be permanently removed.
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Tab switching
        $('.tab-btn').on('click', function() {
            // Remove active class from all tabs
            $('.tab-btn').removeClass('active-tab').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
            $('.tab-btn').removeClass('border-purple-500 text-purple-600');

            // Add active class to clicked tab
            $(this).addClass('active-tab border-purple-500 text-purple-600').removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

            // Hide all tab content
            $('.tab-content').addClass('hidden');

            // Show the corresponding content
            if ($(this).attr('id') === 'company-tab') {
                $('#company-content').removeClass('hidden');
            } else if ($(this).attr('id') === 'activity-tab') {
                $('#activity-content').removeClass('hidden');
            }
        });

        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);

        // Delete provider modal
        $('#delete-provider-btn').on('click', function() {
            const providerId = $(this).data('id');
            const providerName = $(this).data('name');

            // Update the modal content
            $('#providerToDeleteName').text(providerName);
            $('#confirmDeleteBtn').data('id', providerId);

            // Show the delete confirmation modal
            $('#deleteConfirmationModal').removeClass('hidden');
        });

        // Close delete confirmation modal
        $('#cancelDeleteBtn, #deleteConfirmationModal .bg-gray-500').on('click', function(e) {
            if (e.target === this || $(this).attr('id') === 'cancelDeleteBtn') {
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

                        // Redirect to providers list with success message
                        window.location.href = "{{ route('admin.simple-providers-basic') }}?deleted=1";
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
