@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile Settings</h1>
        <p class="text-lg text-gray-600">Manage your account information and preferences</p>

        @if(session('success'))
            <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($error))
            <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded animate__animated animate__fadeIn">
                {{ $error }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">
            <!-- Left sidebar for profile image and summary -->
            <div class="w-full md:w-1/3 bg-gray-50 p-6 border-b md:border-b-0 md:border-r border-gray-200">
                <div class="text-center">
                    <div class="relative mx-auto w-32 h-32 mb-4 group">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="rounded-full w-32 h-32 object-cover border-4 border-white shadow-md">
                        @else
                            <div class="rounded-full w-32 h-32 bg-purple-100 flex items-center justify-center text-purple-600 text-4xl font-bold border-4 border-white shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif

                        <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" id="upload-trigger">
                            <div class="text-white text-sm font-medium">
                                Change<br>Photo
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-500 mb-4">{{ Auth::user()->email }}</p>

                    <div class="flex justify-center mb-6">
                        <span class="px-3 py-1 text-xs rounded-full bg-purple-100 text-purple-800 font-semibold uppercase">Administrator</span>
                    </div>

                    <div class="space-y-2 text-left text-sm">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Joined: {{ Auth::user()->created_at->format('M d, Y') }}</span>
                        </div>
                        @if(Auth::user()->phone)
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ Auth::user()->phone }}</span>
                        </div>
                        @endif
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <span>Last login: {{ Auth::user()->last_login_at ?? 'Never' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Hidden file upload form -->
                <form id="profile-image-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="file" name="profile_image" id="profile-image-input" accept="image/*">
                </form>
            </div>

            <!-- Right content area with tabs -->
            <div class="w-full md:w-2/3 p-0">
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="profileTabs" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-purple-600 hover:border-purple-300 active-tab"
                                id="personal-tab" data-target="personal-content" type="button" role="tab">
                                Personal Information
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-purple-600 hover:border-purple-300"
                                id="security-tab" data-target="security-content" type="button" role="tab">
                                Security
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="p-6">
                    <!-- Personal Information Tab -->
                    <div id="personal-content" class="tab-content">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? old('name') }}"
                                        class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                    @error('name')
                                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? old('email') }}"
                                        class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                    @error('email')
                                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone ?? old('phone') }}"
                                    class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                @error('phone')
                                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab -->
                    <div id="security-content" class="tab-content hidden">
                        <form action="{{ route('admin.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password"
                                        class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700" data-target="current_password">
                                        <svg class="h-5 w-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg class="h-5 w-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password')
                                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700" data-target="password">
                                        <svg class="h-5 w-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg class="h-5 w-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long</div>
                                @error('password')
                                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md shadow-sm transition duration-150">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700" data-target="password_confirmation">
                                        <svg class="h-5 w-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg class="h-5 w-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Tab switching functionality
        $('#profileTabs button').on('click', function() {
            // Remove active state from all tabs
            $('#profileTabs button').removeClass('text-purple-600 border-purple-600 active-tab')
                                  .addClass('border-transparent');

            // Add active state to clicked tab
            $(this).addClass('text-purple-600 border-purple-600 active-tab')
                   .removeClass('border-transparent');

            // Hide all tab content
            $('.tab-content').addClass('hidden');

            // Show the related content
            $('#' + $(this).data('target')).removeClass('hidden');
        });

        // Password visibility toggle
        $('.password-toggle').on('click', function() {
            const targetId = $(this).data('target');
            const passwordInput = $('#' + targetId);

            // Toggle password visibility
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                $(this).find('.eye-icon').addClass('hidden');
                $(this).find('.eye-slash-icon').removeClass('hidden');
            } else {
                passwordInput.attr('type', 'password');
                $(this).find('.eye-icon').removeClass('hidden');
                $(this).find('.eye-slash-icon').addClass('hidden');
            }
        });

        // Profile image upload functionality
        $('#upload-trigger').on('click', function() {
            $('#profile-image-input').click();
        });

        $('#profile-image-input').on('change', function() {
            if (this.files && this.files[0]) {
                // Show preview if needed
                var reader = new FileReader();
                reader.onload = function(e) {
                    // You can add preview functionality here if desired
                }
                reader.readAsDataURL(this.files[0]);

                // Automatically submit the form when a file is selected
                $('#profile-image-form').submit();
            }
        });

        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            $('.bg-green-100').fadeOut('slow');
        }, 5000);

        // DIRECT FIX FOR SECURITY TAB AND PROFILE IMAGE
        // Explicit direct click handler for security tab
        $('#security-tab').click(function(e) {
            e.preventDefault();
            // Hide personal content
            $('#personal-content').addClass('hidden');
            // Show security content
            $('#security-content').removeClass('hidden');
            // Update tab styling
            $('#personal-tab').removeClass('text-purple-600 border-purple-600 active-tab').addClass('border-transparent');
            $(this).addClass('text-purple-600 border-purple-600 active-tab').removeClass('border-transparent');
        });

        // Explicit fix for profile image upload
        $('body').on('click', '#upload-trigger', function() {
            document.getElementById('profile-image-input').click();
        });
    });
</script>
@endsection
