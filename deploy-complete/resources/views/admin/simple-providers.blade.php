@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto">
    <!-- Header with title and add button -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Providers Management</h1>
            <p class="mt-1 text-gray-600">Manage all provider accounts on the platform</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button id="createProviderBtn" type="button" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-white tracking-wide hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 transition ease-in-out duration-150">
                <i class="fas fa-plus-circle mr-2"></i>
                New Provider
            </button>
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
            <form id="searchForm" action="{{ route('admin.simple-providers') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
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

                <!-- Created Date Filter -->
                <div class="w-full md:w-48">
                    <label for="date_filter" class="sr-only">Date</label>
                    <select id="date_filter" name="date_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>This Year</option>
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
                                            <button data-id="{{ $provider->id }}" class="view-provider flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md transition duration-150 ease-in-out">
                                                <i class="fas fa-eye mr-1"></i>
                                                View
                                            </button>
                                            <a href="{{ route('admin.providers.edit', $provider->id) }}" class="flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-md transition duration-150 ease-in-out">
                                                <i class="fas fa-pencil-alt mr-1"></i>
                                                Edit
                                            </a>
                                            <button data-id="{{ $provider->id }}" class="delete-provider flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition duration-150 ease-in-out">
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

@section('modals')
<!-- View Provider Modal -->
<div id="viewProviderModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center" id="modal-title">
                    <i class="fas fa-user-tie mr-2"></i>
                    Provider Details
                </h3>
                <button type="button" id="closeProviderModal" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="bg-white px-6 py-4">
                <!-- Provider Avatar and Basic Info -->
                <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                    <div id="providerAvatar" class="flex-shrink-0 h-16 w-16 mr-4">
                        <!-- Avatar will be populated via JavaScript -->
                    </div>
                    <div>
                        <h4 id="providerName" class="text-xl font-semibold text-gray-800"></h4>
                        <p id="providerUsername" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <!-- Provider Details -->
                <div class="space-y-4">
                    <!-- Email -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email Address</p>
                            <p id="providerEmail" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div id="providerPhoneContainer" class="flex items-center hidden">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mr-3">
                            <i class="fas fa-phone-alt text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Phone Number</p>
                            <p id="providerPhone" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <!-- Company Name -->
                    <div id="providerCompanyContainer" class="flex items-center hidden">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mr-3">
                            <i class="fas fa-building text-indigo-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Company Name</p>
                            <p id="providerCompany" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Account Status</p>
                            <div id="providerStatus"></div>
                        </div>
                    </div>

                    <!-- Verification -->
                    <div id="providerVerificationContainer" class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mr-3">
                            <i class="fas fa-certificate text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Verification Status</p>
                            <div id="providerVerification"></div>
                        </div>
                    </div>

                    <!-- Registration Date -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Registration Date</p>
                            <p id="providerRegisteredOn" class="font-medium text-gray-700"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition duration-150 ease-in-out" onclick="$('#viewProviderModal').addClass('hidden')">
                    <i class="fas fa-times mr-2"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center" id="modal-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Delete Provider
                </h3>
                <button type="button" id="cancelDelete" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="bg-white px-6 py-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mr-4">
                        <i class="fas fa-user-times text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 font-medium mb-2">Are you sure you want to delete this provider?</p>
                        <p class="text-sm text-gray-600">
                            All of their data, including business information and activities, will be permanently removed from the system.
                            This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-sm transition duration-150 ease-in-out" id="cancelDeleteBtn">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>
                <button type="button" id="confirmDeleteBtn" class="inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-submit the form when a filter changes
        $('#date_filter, #status').on('change', function() {
            $('#searchForm').submit();
        });

        // Reset filters button
        $('#resetFilters').on('click', function() {
            $('#search').val('');
            $('#date_filter').val('');
            $('#status').val('');
            $('#searchForm').submit();
        });

        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);

        // View Provider
        $('.view-provider').on('click', function() {
            const providerId = $(this).data('id');

            // Show loading state
            $('#providerName').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');
            $('#providerUsername').html('<div class="animate-pulse h-5 w-16 bg-gray-200 rounded"></div>');
            $('#providerEmail').html('<div class="animate-pulse h-5 w-32 bg-gray-200 rounded"></div>');
            $('#providerStatus').html('<div class="animate-pulse h-5 w-20 bg-gray-200 rounded"></div>');
            $('#providerRegisteredOn').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');

            // Show the modal
            $('#viewProviderModal').removeClass('hidden');

            // Fetch provider data via AJAX
            $.ajax({
                url: `/api/providers/${providerId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const provider = response.provider;

                    // Update modal content
                    $('#providerName').text(provider.name);
                    $('#providerUsername').text(provider.username || 'No username');
                    $('#providerEmail').text(provider.email);

                    // Handle phone display
                    if (provider.phone) {
                        $('#providerPhone').text(provider.phone);
                        $('#providerPhoneContainer').removeClass('hidden');
                    } else {
                        $('#providerPhoneContainer').addClass('hidden');
                    }

                    // Handle company display
                    if (provider.shop_info && provider.shop_info.company_name) {
                        $('#providerCompany').text(provider.shop_info.company_name);
                        $('#providerCompanyContainer').removeClass('hidden');
                    } else {
                        $('#providerCompanyContainer').addClass('hidden');
                    }

                    // Handle status badge
                    let statusBadge = '';
                    if (provider.status === 'active') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Active</span></div>';
                    } else if (provider.status === 'inactive') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Inactive</span></div>';
                    } else if (provider.status === 'pending') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Pending</span></div>';
                    } else {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"><i class="fas fa-question-circle mr-1"></i>Unknown</span></div>';
                    }
                    $('#providerStatus').html(statusBadge);

                    // Handle verification badge
                    let verificationBadge = '';
                    if (provider.shop_info && provider.shop_info.is_verified) {
                        verificationBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Verified</span></div>';
                    } else {
                        verificationBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"><i class="fas fa-times-circle mr-1"></i>Not Verified</span></div>';
                    }
                    $('#providerVerification').html(verificationBadge);

                    // Format and display registration date
                    const registerDate = new Date(provider.created_at);
                    const formattedDate = registerDate.toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    $('#providerRegisteredOn').text(formattedDate);

                    // Handle avatar
                    if (provider.profile_image) {
                        $('#providerAvatar').html(`<img class="h-16 w-16 rounded-full object-cover ring-2 ring-purple-500" src="/storage/${provider.profile_image}" alt="${provider.name}">`);
                    } else {
                        const initial = provider.name.charAt(0).toUpperCase();
                        $('#providerAvatar').html(`<div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl">${initial}</div>`);
                    }
                },
                error: function(error) {
                    console.error('Error fetching provider data:', error);
                    $('#viewProviderModal').addClass('hidden');
                    alert('Error fetching provider details. Please try again.');
                }
            });
        });

        // Close view provider modal
        $('#closeProviderModal, #viewProviderModal .bg-gray-500').on('click', function(e) {
            if (e.target === this) {
                $('#viewProviderModal').addClass('hidden');
            }
        });

        // Create new provider - redirect to dedicated page
        $('#createProviderBtn').on('click', function() {
            window.location.href = "{{ route('admin.providers.edit', ['id' => 'new']) }}";
        });

        // Delete provider
        $('.delete-provider').on('click', function() {
            const providerId = $(this).data('id');
            const providerName = $(this).closest('tr').find('.text-gray-900').first().text();

            // Update confirm delete button with provider ID
            $('#confirmDeleteBtn').data('id', providerId);

            // Show confirmation modal
            $('#deleteConfirmationModal').removeClass('hidden');
        });

        // Cancel delete
        $('#cancelDelete, #cancelDeleteBtn, #deleteConfirmationModal .bg-gray-500').on('click', function(e) {
            if (e.target === this || e.target.id === 'cancelDelete' || e.target.id === 'cancelDeleteBtn') {
                $('#deleteConfirmationModal').addClass('hidden');
            }
        });

        // Confirm delete
        $('#confirmDeleteBtn').on('click', function() {
            const providerId = $(this).data('id');

            // Send delete request
            $.ajax({
                url: `/api/providers/${providerId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hide modal and refresh page
                    $('#deleteConfirmationModal').addClass('hidden');
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error deleting provider:', error);
                    $('#deleteConfirmationModal').addClass('hidden');
                    alert('Error deleting provider. Please try again.');
                }
            });
        });
    });
</script>
@endsection
