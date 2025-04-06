<div>
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Filter Controls - For mobile filters that will show/hide on smaller screens -->
    <div class="md:hidden mb-6">
        <div class="relative">
            <div class="flex items-center">
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="overflow-x-auto" wire:loading.class="opacity-75">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <div class="flex items-center">
                                    <input wire:model.live="selectAll" id="select-all" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="select-all" class="sr-only">Select All</label>
                                </div>
                            </th>
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
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input wire:model.live="selectedCustomers" value="{{ $customer->id }}" id="customer-{{ $customer->id }}" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <label for="customer-{{ $customer->id }}" class="sr-only">Select Customer</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($customer->profile_image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $customer->profile_image }}" alt="{{ $customer->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xl">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $customer->username }}</div>
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @elseif($customer->status === 'inactive')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Inactive</span>
                                        @elseif($customer->status === 'blocked')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Blocked</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $customer->status }}</span>
                                        @endif
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button wire:click="viewCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-900 border border-blue-600 rounded px-2 py-1 transition duration-150 ease-in-out">
                                            View
                                        </button>
                                        <button wire:click="confirmCustomerDeletion({{ $customer->id }})" class="text-red-600 hover:text-red-900 border border-red-600 rounded px-2 py-1 transition duration-150 ease-in-out">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination and bulk actions section -->
    @if($customers->count() > 0)
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4 rounded-lg shadow-sm">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $customers->links('pagination::simple-tailwind') }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <div class="mr-2">
                        <label for="bulkAction" class="sr-only">Bulk actions</label>
                        <select wire:model.live="bulkAction" id="bulkAction" name="bulkAction" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Bulk actions</option>
                            <option value="delete">Delete selected</option>
                            <option value="activate">Activate selected</option>
                            <option value="deactivate">Deactivate selected</option>
                            <option value="block">Block selected</option>
                        </select>
                    </div>
                    <button wire:click="applyBulkAction" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Apply
                    </button>
                </div>
                <div>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- View Customer Modal -->
    <div x-data="{ open: @entangle('showViewModal') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-[200] overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                @if($viewingCustomer)
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Customer Details
                                </h3>
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($viewingCustomer->profile_image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $viewingCustomer->profile_image }}" alt="{{ $viewingCustomer->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xl">
                                            {{ substr($viewingCustomer->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Full Name</span>
                                    <p class="font-medium">{{ $viewingCustomer->name }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Username</span>
                                    <p class="font-medium">{{ $viewingCustomer->username }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Email</span>
                                    <p class="font-medium">{{ $viewingCustomer->email }}</p>
                                </div>
                                @if($viewingCustomer->phone)
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Phone</span>
                                    <p class="font-medium">{{ $viewingCustomer->phone }}</p>
                                </div>
                                @endif
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Status</span>
                                    <p>
                                        @if(isset($viewingCustomer->status))
                                            @if($viewingCustomer->status === 'active')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            @elseif($viewingCustomer->status === 'inactive')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Inactive</span>
                                            @elseif($viewingCustomer->status === 'blocked')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Blocked</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $viewingCustomer->status }}</span>
                                            @endif
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Registered Date</span>
                                    <p class="font-medium">{{ $viewingCustomer->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Last Updated</span>
                                    <p class="font-medium">{{ $viewingCustomer->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeViewModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: @entangle('confirmingCustomerDeletion') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-[200] overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation -->
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Customer
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this customer? All of their data will be permanently removed.
                                    This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteCustomer" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button wire:click="cancelCustomerDeletion" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
