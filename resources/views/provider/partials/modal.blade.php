{{--
    Reusable Modal Component

    Parameters:
    - $id: The unique ID for the modal
    - $title: The title to display in the modal header
    - $modalClass (optional): Additional classes for the modal

    Usage example:
    @include('provider.partials.modal', [
        'id' => 'profile-edit-modal',
        'title' => 'Edit Profile',
    ])
    <div id="profile-edit-modal-content">
        <!-- Your modal content here -->
    </div>
--}}

<div
    id="{{ $id }}"
    class="fixed inset-0 overflow-y-auto hidden z-50"
    aria-labelledby="{{ $id }}-title"
    role="dialog"
    aria-modal="true"
>
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="hideModal('{{ $id }}')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full {{ $modalClass ?? '' }}">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 py-4 sm:px-6 sm:flex sm:flex-row sm:items-center">
                <div class="flex-1">
                    <h3 class="text-lg leading-6 font-medium text-white" id="{{ $id }}-title">
                        {{ $title }}
                    </h3>
                    @if(isset($subtitle))
                        <p class="mt-1 text-sm text-teal-100">{{ $subtitle }}</p>
                    @endif
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-4">
                    <button
                        type="button"
                        class="bg-teal-600 rounded-md text-white hover:text-gray-200 focus:outline-none"
                        onclick="hideModal('{{ $id }}')"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="px-4 py-5 sm:p-6" id="{{ $id }}-content">
                <!-- Modal content will be loaded here dynamically -->
            </div>

            <!-- Footer (optional) -->
            @if(isset($showFooter) && $showFooter)
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 border-t border-gray-200">
                    <div id="{{ $id }}-footer">
                        <!-- Footer content will be loaded here dynamically -->
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
