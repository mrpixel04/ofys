@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Customer Management</h1>
        <p class="text-lg text-gray-600">View and manage all customer accounts on your platform.</p>

        @if(session('success'))
            <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate__animated animate__fadeIn">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search & Filter
            </h2>
        </div>
        <div class="p-8">
            <form id="searchForm" action="{{ route('admin.customers') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                    <!-- Customer Name Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Customer Name or Email</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request()->search }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg"
                                placeholder="Search by name or email...">
                        </div>
                    </div>

                    <!-- Registration Date Filter -->
                    <div>
                        <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Registration Date</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <select id="date_filter" name="date_filter"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                <option value="">All Time</option>
                                <option value="today" {{ request()->date_filter == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request()->date_filter == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request()->date_filter == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ request()->date_filter == 'year' ? 'selected' : '' }}>This Year</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select id="status" name="status"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="blocked" {{ request()->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="button" id="resetFilters"
                        class="flex justify-center items-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filters
                    </button>
                    <button type="submit"
                        class="flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Customers
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                All Customers
            </h2>
            <div class="text-sm text-gray-500">Total: <span class="font-semibold">{{ $customers->total() }}</span> customers</div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registered On
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($customer->profile_image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $customer->profile_image) }}" alt="{{ $customer->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-xl">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $customer->username ?? 'No username' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                    @if($customer->phone)
                                        <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($customer->status))
                                        @if($customer->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        @elseif($customer->status === 'inactive')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Inactive
                                            </span>
                                        @elseif($customer->status === 'blocked')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-ban mr-1"></i>Blocked
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-question-circle mr-1"></i>{{ $customer->status }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button data-id="{{ $customer->id }}" class="view-customer flex items-center justify-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md transition duration-150 ease-in-out">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </button>
                                        <button data-id="{{ $customer->id }}" class="delete-customer flex items-center justify-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition duration-150 ease-in-out">
                                            <i class="fas fa-trash-alt mr-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($customers->count() > 0)
                <div class="mt-6">
                    {{ $customers->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Customer Modal -->
<div id="viewCustomerModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                    <i class="fas fa-user-circle mr-2"></i>
                    Customer Details
                </h3>
                <button type="button" id="closeCustomerModal" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="bg-white px-6 py-4">
                <!-- Customer Avatar and Basic Info -->
                <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                    <div id="customerAvatar" class="flex-shrink-0 h-16 w-16 mr-4"></div>
                    <div>
                        <h4 id="customerName" class="text-xl font-semibold text-gray-800"></h4>
                        <p id="customerUsername" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email Address</p>
                            <p id="customerEmail" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <div id="customerPhoneContainer" class="flex items-center hidden">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mr-3">
                            <i class="fas fa-phone-alt text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Phone Number</p>
                            <p id="customerPhone" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Account Status</p>
                            <div id="customerStatus"></div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Registration Date</p>
                            <p id="customerRegisteredOn" class="font-medium text-gray-700"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition duration-150 ease-in-out" onclick="$('#viewCustomerModal').addClass('hidden')">
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
                    Delete Customer
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
                        <p class="text-gray-800 font-medium mb-2">Are you sure you want to delete this customer?</p>
                        <p class="text-sm text-gray-600">
                            All of their data will be permanently removed from the system.
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
                <form id="deleteCustomerForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm transition duration-150 ease-in-out">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Reset filters button
        $('#resetFilters').on('click', function() {
            $('#search').val('');
            $('#date_filter').val('');
            $('#status').val('');
            $('#searchForm').submit();
        });

        // Auto-submit the form when a filter changes
        $('#date_filter, #status').on('change', function() {
            $('#searchForm').submit();
        });

        // View customer modal
        $('.view-customer').on('click', function() {
            const customerId = $(this).data('id');

            // Show loading state
            $('#customerName').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');
            $('#customerUsername').html('<div class="animate-pulse h-5 w-16 bg-gray-200 rounded"></div>');
            $('#customerEmail').html('<div class="animate-pulse h-5 w-32 bg-gray-200 rounded"></div>');
            $('#customerStatus').html('<div class="animate-pulse h-5 w-20 bg-gray-200 rounded"></div>');
            $('#customerRegisteredOn').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');

            // Show the modal
            $('#viewCustomerModal').removeClass('hidden');

            // Fetch customer data via AJAX
            $.ajax({
                url: `{{ route('admin.customers') }}/${customerId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Check if we have a customer object directly or nested in response.customer
                    const customer = response.customer || response;

                    // Update modal content
                    $('#customerName').text(customer.name);
                    $('#customerUsername').text(customer.username || 'No username');
                    $('#customerEmail').text(customer.email);

                    // Handle phone display
                    if (customer.phone) {
                        $('#customerPhone').text(customer.phone);
                        $('#customerPhoneContainer').removeClass('hidden');
                    } else {
                        $('#customerPhoneContainer').addClass('hidden');
                    }

                    // Handle status badge with modern design
                    let statusBadge = '';
                    if (customer.status === 'active') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Active</span></div>';
                    } else if (customer.status === 'inactive') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Inactive</span></div>';
                    } else if (customer.status === 'blocked') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-ban mr-1"></i>Blocked</span></div>';
                    } else {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Active</span></div>';
                    }
                    $('#customerStatus').html(statusBadge);

                    // Format and display registration date
                    const registerDate = new Date(customer.created_at);
                    const formattedDate = registerDate.toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    $('#customerRegisteredOn').text(formattedDate);

                    // Handle avatar
                    if (customer.profile_image) {
                        $('#customerAvatar').html(`<img class="h-16 w-16 rounded-full object-cover ring-2 ring-purple-500" src="/storage/${customer.profile_image}" alt="${customer.name}">`);
                    } else {
                        const initial = customer.name.charAt(0).toUpperCase();
                        $('#customerAvatar').html(`<div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl ring-2 ring-purple-300">${initial}</div>`);
                    }
                },
                error: function(error) {
                    console.error('Error fetching customer data:', error);
                    $('#viewCustomerModal').addClass('hidden');
                    alert('Error fetching customer details. Please try again.');
                }
            });
        });

        // Close view customer modal
        $('#closeCustomerModal').on('click', function() {
            $('#viewCustomerModal').addClass('hidden');
        });

        // Delete customer - Show confirmation modal
        $('.delete-customer').on('click', function() {
            const customerId = $(this).data('id');
            $('#deleteCustomerForm').attr('action', `/admin/customers/${customerId}`);
            $('#deleteConfirmationModal').removeClass('hidden');
        });

        // Cancel delete
        $('#cancelDelete, #cancelDeleteBtn').on('click', function() {
            $('#deleteConfirmationModal').addClass('hidden');
        });

        // Close modals when clicking outside
        $(window).on('click', function(event) {
            if ($(event.target).hasClass('fixed') && $(event.target).hasClass('inset-0')) {
                $('#viewCustomerModal').addClass('hidden');
                $('#deleteConfirmationModal').addClass('hidden');
            }
        });
    });
</script>
@endsection
