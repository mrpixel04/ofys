@extends('layouts.provider.simple-app')

@section('header', 'My Profile')

@section('breadcrumbs')
    @include('layouts.partials.breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('provider.dashboard')],
            ['label' => 'My Profile'],
        ],
    ])
@endsection

@section('header_subtitle')
    Review your account details, update contact information, and secure your password.
@endsection

@section('header_actions')
    <div class="flex space-x-3">
        <button
            onclick="showModal('profile-edit-modal')"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Profile
        </button>

        <button
            onclick="showModal('password-edit-modal')"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            Change Password
        </button>
    </div>
@endsection

@section('content')
    <div class="bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gradient-to-r from-teal-500 to-teal-600">
            <h3 class="text-lg leading-6 font-medium text-white">Provider Profile Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-teal-100">Personal details and contact information.</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <!-- Profile Image -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-white">
                    <dt class="text-sm font-medium text-gray-500">Profile Image</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex items-center">
                            <div class="h-20 w-20 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center shadow-md">
                                @if($user->profile_image)
                                    <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </dd>
                </div>

                <!-- Full name -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Full name
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-medium">{{ $user->name }}</dd>
                </div>

                <!-- Email address -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-white">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                </div>

                <!-- Username -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        Username
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->username ?? 'Not set' }}</dd>
                </div>

                <!-- Phone number -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-white">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Phone number
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->phone ?? 'Not provided' }}</dd>
                </div>

                <!-- Account Status -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Account Status
                    </dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        @if($user->status === 'active')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Active
                            </span>
                        @elseif($user->status === 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pending Approval
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Inactive
                            </span>
                        @endif
                    </dd>
                </div>

                <!-- Registration date -->
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-white">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Joined
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->created_at->format('F j, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Profile Edit Modal -->
    @include('provider.partials.form-modal', [
        'id' => 'profile-edit-modal',
        'title' => 'Edit Profile',
        'subtitle' => 'Update your personal information',
        'formAction' => route('provider.profile.update'),
        'formMethod' => 'POST',
    ])

    <template id="profile-edit-modal-template">
        <!-- Profile Image -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
            <div class="flex items-center">
                <div class="relative mr-4">
                    <div id="profile-image-preview" class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center shadow">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="Profile Photo" class="h-full w-full object-cover">
                        @else
                            <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <label for="profile-upload" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 cursor-pointer transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Upload Image
                    </label>
                    <input id="profile-upload" name="profile_image" type="file" class="hidden" accept="image/*" />

                    @if($user->profile_image)
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="remove_profile_image" name="remove_profile_image" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                            <label for="remove_profile_image" class="text-sm text-red-600">Remove current image</label>
                        </div>
                    @endif
                </div>
            </div>
            <div id="profile-image-error" class="mt-1 text-sm text-red-600 hidden">Profile image must be valid and under 1MB.</div>
        </div>

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <div class="mt-1">
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Your full name" required>
            </div>
            <div id="name-error" class="mt-1 text-sm text-red-600 hidden">Your name is required.</div>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <div class="mt-1">
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="you@example.com" required>
            </div>
        </div>

        <!-- Username Field - Disabled -->
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <div class="mt-1">
                <input type="text" name="username" id="username" value="{{ $user->username }}" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly disabled>
                <p class="mt-1 text-xs text-gray-500">Username cannot be changed.</p>
            </div>
        </div>

        <!-- Phone Field -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <div class="mt-1">
                <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="+60 12-345-6789">
            </div>
            <div id="phone-error" class="mt-1 text-sm text-red-600 hidden">Please enter a valid phone number.</div>
        </div>
    </template>

    <!-- Password Edit Modal -->
    @include('provider.partials.form-modal', [
        'id' => 'password-edit-modal',
        'title' => 'Change Password',
        'subtitle' => 'Update your account password',
        'formAction' => route('provider.password.update'),
        'formMethod' => 'POST',
    ])

    <template id="password-edit-modal-template">
        <!-- Current Password Field -->
        <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <div class="mt-1 relative">
                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                    placeholder="Enter your current password"
                    required
                >
                <button
                    type="button"
                    class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center"
                    data-target="current_password"
                >
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div id="current-password-error" class="mt-1 text-sm text-red-600 hidden">Current password is required.</div>
        </div>

        <!-- New Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <div class="mt-1 relative">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                    placeholder="Enter new password"
                    required
                    minlength="8"
                >
                <button
                    type="button"
                    class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center"
                    data-target="password"
                >
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long.</div>
            <div id="password-error" class="mt-1 text-sm text-red-600 hidden">Password must be at least 8 characters long.</div>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <div class="mt-1 relative">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                    placeholder="Confirm new password"
                    required
                >
                <button
                    type="button"
                    class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center"
                    data-target="password_confirmation"
                >
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div id="password-confirmation-error" class="mt-1 text-sm text-red-600 hidden">Passwords do not match.</div>
        </div>
    </template>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Preview uploaded profile image (works for dynamically injected markup)
        $(document).on('change', '#profile-upload', function() {
            const file = this.files[0];
            const preview = $('#profile-image-preview');
            if (file && preview.length) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.html(`<img src="${e.target.result}" alt="Profile Preview" class=\"h-full w-full object-cover\">`);
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation for profile edit
        $('#profile-edit-modal-form').on('submit', function(e) {
            // Check if name is filled
            if (!$('#name').val()) {
                $('#name-error').removeClass('hidden');
                e.preventDefault();
            } else {
                $('#name-error').addClass('hidden');
            }

            // Validate phone number if provided
            const phone = $('#phone').val();
            if (phone && !(/^[+]?[(]?[0-9]{1,4}[)]?[-\s.]?[0-9]{1,4}[-\s.]?[0-9]{1,9}$/.test(phone))) {
                $('#phone-error').removeClass('hidden');
                e.preventDefault();
            } else {
                $('#phone-error').addClass('hidden');
            }
        });

        // Password form validation
        $('#password-edit-modal-form').on('submit', function(e) {
            let valid = true;

            // Validate current password
            if (!$('#current_password').val()) {
                $('#current-password-error').removeClass('hidden');
                valid = false;
            } else {
                $('#current-password-error').addClass('hidden');
            }

            // Validate new password
            const password = $('#password').val();
            if (!password || password.length < 8) {
                $('#password-error').removeClass('hidden');
                valid = false;
            } else {
                $('#password-error').addClass('hidden');
            }

            // Validate password confirmation
            if (password !== $('#password_confirmation').val()) {
                $('#password-confirmation-error').removeClass('hidden');
                valid = false;
            } else {
                $('#password-confirmation-error').addClass('hidden');
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
