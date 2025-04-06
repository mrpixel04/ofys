{{--
    Form Modal Component

    Parameters:
    - $id: Required. Unique identifier for the modal
    - $title: Required. The modal title
    - $formAction: Required. The form submission URL
    - $formMethod: Required. The form submission method (POST, GET, etc.)
    - $subtitle: Optional. A smaller subtitle below the main title
    - $modalClass: Optional. Additional CSS classes for the modal
    - $formId: Optional. ID for the form element (defaults to "$id-form")

    Usage:
    @include('provider.partials.form-modal', [
        'id' => 'my-modal',
        'title' => 'Modal Title',
        'formAction' => route('some.route'),
        'formMethod' => 'POST',
    ])

    To show/hide:
    <button onclick="showModal('my-modal')">Open Modal</button>

    Content is placed in a div with id="my-modal-content"
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
            <!-- Form -->
            <form
                id="{{ $formId ?? $id . '-form' }}"
                action="{{ $formAction }}"
                method="{{ $formMethod }}"
                enctype="multipart/form-data"
            >
                @csrf

                <!-- If method is PUT/PATCH/DELETE, add method field -->
                @if(strtoupper($formMethod) === 'PUT' || strtoupper($formMethod) === 'PATCH' || strtoupper($formMethod) === 'DELETE')
                    @method(strtoupper($formMethod))
                @endif

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
                <div class="px-4 py-5 sm:p-6 overflow-y-auto max-h-[70vh]" id="{{ $id }}-content">
                    <!-- Modal content will be placed here -->
                </div>

                <!-- Footer -->
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-gray-50 border-t border-gray-200">
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Save
                    </button>
                    <button
                        type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="hideModal('{{ $id }}')"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
