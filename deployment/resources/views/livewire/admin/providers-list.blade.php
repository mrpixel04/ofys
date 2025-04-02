<div>
    <div class="container mx-auto">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Provider Management</h1>
                <p class="mt-1 text-gray-600">Manage all provider accounts on the platform</p>
            </div>
            <div class="mt-4 md:mt-0">
                <livewire:admin.create-provider />
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Card container for the table and filters -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Top section with filters -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="search" id="search" name="search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 sm:text-sm border-gray-300 rounded-md" placeholder="Search providers...">
                        </div>
                    </div>

                    <!-- Status Filter - Note: We're assuming the status field exists, if not this will need to be adjusted -->
                    <div class="w-full md:w-48">
                        <label for="statusFilter" class="sr-only">Status</label>
                        <select wire:model.live="statusFilter" id="statusFilter" name="statusFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending Approval</option>
                        </select>
                    </div>

                    <!-- Created Date Filter -->
                    <div class="w-full md:w-48">
                        <label for="dateFilter" class="sr-only">Date</label>
                        <select wire:model.live="dateFilter" id="dateFilter" name="dateFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table section -->
            <div class="overflow-x-auto" wire:loading.class="opacity-75">
                <div class="align-middle inline-block min-w-full">
                    <div class="overflow-hidden">
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
                                                <input wire:model.live="selectedProviders" value="{{ $provider->id }}" id="provider-{{ $provider->id }}" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                <label for="provider-{{ $provider->id }}" class="sr-only">Select Provider</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <!-- Using a default avatar or the first letter of their name -->
                                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                                                        {{ substr($provider->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $provider->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $provider->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $provider->username }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($provider->status))
                                                @if($provider->status === 'active')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                                @elseif($provider->status === 'inactive')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                                @elseif($provider->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Approval</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $provider->status }}</span>
                                                @endif
                                            @else
                                                <!-- If no status field exists, we can assume all providers are active -->
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $provider->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button wire:click="viewProvider({{ $provider->id }})" class="text-blue-600 hover:text-blue-900 border border-blue-600 rounded px-2 py-1">
                                                    View
                                                </button>
                                                <button wire:click="editProvider({{ $provider->id }})" class="text-yellow-600 hover:text-yellow-900 border border-yellow-600 rounded px-2 py-1">
                                                    Edit
                                                </button>
                                                <button wire:click="confirmProviderDeletion({{ $provider->id }})" class="text-red-600 hover:text-red-900 border border-red-600 rounded px-2 py-1">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No providers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination and bulk actions section -->
            @if($providers->count() > 0)
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        {{ $providers->links('pagination::simple-tailwind') }}
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
                                </select>
                            </div>
                            <button wire:click="applyBulkAction" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Apply
                            </button>
                        </div>
                        <div>
                            {{ $providers->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- View Provider Modal -->
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

                @if($viewingProvider)
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Provider Details
                                </h3>
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                                        {{ substr($viewingProvider->name, 0, 1) }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="border-b pb-2">
                                    <h4 class="text-sm font-medium text-gray-500">Basic Information</h4>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Name</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Username</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->username }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Status</p>
                                            <p class="text-sm font-medium">
                                                @if(isset($viewingProvider->status))
                                                    {{ ucfirst($viewingProvider->status) }}
                                                @else
                                                    Active
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if($viewingProvider->shopInfo)
                                <div class="border-b pb-2">
                                    <h4 class="text-sm font-medium text-gray-500">Company Information</h4>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Company Name</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->shopInfo->company_name }}</p>
                                        </div>
                                        @if($viewingProvider->shopInfo->business_type)
                                        <div>
                                            <p class="text-xs text-gray-500">Business Type</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->shopInfo->business_type }}</p>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="text-xs text-gray-500">Verified</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->shopInfo->is_verified ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Account Information</h4>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Created On</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Last Updated</p>
                                            <p class="text-sm font-medium">{{ $viewingProvider->updated_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closeViewModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: @entangle('confirmingProviderDeletion') }"
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
                                Delete Provider
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this provider? All data will be permanently removed. This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteProvider" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button wire:click="cancelProviderDeletion" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Edit Provider Component -->
    <livewire:admin.edit-provider />
</div>
