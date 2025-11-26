@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb navigation -->
    <div class="mb-4 flex items-center space-x-2 text-sm">
        <a href="{{ route('admin.simple-providers-basic') }}" class="text-purple-600 hover:text-purple-900 flex items-center transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Vendors
        </a>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700">{{ isset($provider) && $provider->id ? 'Edit Vendor' : 'Add New Vendor' }}</span>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
            <div class="flex items-center">
                <div class="rounded-full bg-white/20 p-3 mr-4">
                    <i class="fas {{ isset($provider) && $provider->id ? 'fa-user-edit' : 'fa-user-plus' }} text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ isset($provider) && $provider->id ? 'Edit Vendor' : 'Add New Vendor' }}</h1>
                    <p class="text-purple-100 mt-1">{{ isset($provider) && $provider->id ? 'Update vendor information and settings' : 'Create a new vendor account' }}</p>
                </div>
            </div>
        </div>

        <!-- Flash messages -->
        @if (session()->has('success'))
            <div id="success-message" class="m-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div id="error-message" class="m-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="p-6">
            <form id="providerForm" action="{{ isset($provider) && $provider->id ? route('admin.providers.update', $provider->id) : route('admin.providers.update', 'new') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Form sections tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" class="tab-button active border-purple-500 text-purple-600 py-4 px-1 border-b-2 font-medium text-sm group flex items-center" data-tab="basic-info">
                            <span class="bg-purple-100 text-purple-600 p-2 rounded-lg mr-2 group-hover:bg-purple-200 transition-colors">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            Basic Info
                        </button>
                        <button type="button" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 border-b-2 font-medium text-sm group flex items-center" data-tab="company-info">
                            <span class="bg-gray-100 text-gray-500 p-2 rounded-lg mr-2 group-hover:bg-gray-200 transition-colors">
                                <i class="fas fa-building"></i>
                            </span>
                            Company Details
                        </button>
                    </nav>
                </div>

                <!-- Basic Info Tab -->
                <div id="basic-info-tab" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="group">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-user text-purple-500 mr-2"></i>
                                Full Name <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-user"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ $provider->name ?? old('name') }}" required placeholder="John Doe" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-envelope text-purple-500 mr-2"></i>
                                Email Address <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ $provider->email ?? old('email') }}" required placeholder="vendor@example.com" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-at text-purple-500 mr-2"></i>
                                Username
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-id-badge"></i>
                                </div>
                                <input type="text" id="username" name="username" value="{{ $provider->username ?? old('username') }}" placeholder="johndoe" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                Leave blank to auto-generate from email address.
                            </p>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-lock text-purple-500 mr-2"></i>
                                <span id="passwordLabel">
                                    Password
                                    @if(!isset($provider) || !$provider->id)
                                        <span class="text-red-500 ml-1">*</span>
                                    @endif
                                </span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-lock-alt"></i>
                                </div>
                                <input type="password" id="password" name="password" placeholder="••••••••" class="pl-10 pr-10 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base" {{ !isset($provider) || !$provider->id ? 'required' : '' }}>
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p id="passwordNote" class="mt-1 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                @if(isset($provider) && $provider->id)
                                    Leave blank to keep current password.
                                @else
                                    Must be at least 8 characters.
                                @endif
                            </p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-phone text-purple-500 mr-2"></i>
                                Phone Number
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-phone"></i>
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ $provider->phone ?? old('phone') }}" placeholder="+1 (555) 123-4567" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-toggle-on text-purple-500 mr-2"></i>
                                Account Status
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-shield-check"></i>
                                </div>
                                <select id="status" name="status" class="pl-10 pr-10 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 appearance-none text-base">
                                    <option value="active" {{ (isset($provider) && $provider->status === 'active') || old('status') === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ (isset($provider) && $provider->status === 'inactive') || old('status') === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                    <option value="pending" {{ (isset($provider) && $provider->status === 'pending') || old('status') === 'pending' ? 'selected' : '' }}>
                                        Pending Approval
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Upload profile image (placeholder) -->
                        <div class="md:col-span-2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-image text-purple-500 mr-2"></i>
                                Profile Image
                            </label>
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="h-24 w-24 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden border-2 border-purple-200">
                                        @if(isset($provider) && $provider->profile_image)
                                            <img src="{{ asset('storage/' . $provider->profile_image) }}" alt="{{ $provider->name }}" class="h-full w-full object-cover">
                                        @else
                                            <i class="fas fa-user text-purple-300 text-4xl"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-center text-center w-full">
                                        <label for="profile_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-purple-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-cloud-upload-alt mb-3 text-purple-400 text-2xl"></i>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                                            </div>
                                            <input id="profile_image" name="profile_image" type="file" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                Upload a professional profile image for this vendor account.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Company Info Tab -->
                <div id="company-info-tab" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-building text-purple-500 mr-2"></i>
                                Company Name
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-building"></i>
                                </div>
                                <input type="text" id="company_name" name="company_name" value="{{ $provider->shopInfo->company_name ?? old('company_name') }}" placeholder="Outdoor Adventures Inc." class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Company Email -->
                        <div>
                            <label for="company_email" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-envelope-open text-purple-500 mr-2"></i>
                                Company Email
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <input type="email" id="company_email" name="company_email" value="{{ $provider->shopInfo->company_email ?? old('company_email') }}" placeholder="info@company.com" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('company_email')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Business Type -->
                        <div>
                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-briefcase text-purple-500 mr-2"></i>
                                Business Type
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-briefcase"></i>
                                </div>
                                <select id="business_type" name="business_type" class="pl-10 pr-10 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 appearance-none text-base">
                                    <option value="">Select Business Type</option>
                                    <option value="Individual" {{ (isset($provider->shopInfo) && $provider->shopInfo->business_type === 'Individual') || old('business_type') === 'Individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="Company" {{ (isset($provider->shopInfo) && $provider->shopInfo->business_type === 'Company') || old('business_type') === 'Company' ? 'selected' : '' }}>Company</option>
                                    <option value="Partnership" {{ (isset($provider->shopInfo) && $provider->shopInfo->business_type === 'Partnership') || old('business_type') === 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="Non-profit" {{ (isset($provider->shopInfo) && $provider->shopInfo->business_type === 'Non-profit') || old('business_type') === 'Non-profit' ? 'selected' : '' }}>Non-profit</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('business_type')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- SSM Registration Number -->
                        <div>
                            <label for="ssm_number" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-file-contract text-purple-500 mr-2"></i>
                                No. SSM
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <input type="text" id="ssm_number" name="ssm_number" value="{{ $provider->shopInfo->ssm_number ?? old('ssm_number') }}" placeholder="e.g. 202001234567" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('ssm_number')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- E-Invoice Number -->
                        <div>
                            <label for="einvoice_number" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-file-invoice text-purple-500 mr-2"></i>
                                No. E-Invoice
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <input type="text" id="einvoice_number" name="einvoice_number" value="{{ $provider->shopInfo->einvoice_number ?? old('einvoice_number') }}" placeholder="Enter latest E-Invoice reference" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('einvoice_number')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Company website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-globe text-purple-500 mr-2"></i>
                                Website URL
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="far fa-globe"></i>
                                </div>
                                <input type="url" id="website" name="website" value="{{ $provider->shopInfo->website ?? old('website') }}" placeholder="https://www.example.com" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                            </div>
                            @error('website')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-align-left text-purple-500 mr-2"></i>
                                Company Description
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea id="description" name="description" rows="4" placeholder="Describe the company and the services they offer..." class="px-4 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg text-base">{{ $provider->shopInfo->description ?? old('description') }}</textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                Provide a detailed description of the company and their outdoor activities.
                            </p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address Section Card -->
                        <div class="md:col-span-2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="font-medium text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                Company Address
                            </h3>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="far fa-map-marker-alt"></i>
                                    </div>
                                    <input type="text" id="address" name="address" value="{{ $provider->shopInfo->address ?? old('address') }}" placeholder="123 Adventure St." class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                </div>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- City, State & Postal Code in a row -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="far fa-city"></i>
                                        </div>
                                        <input type="text" id="city" name="city" value="{{ $provider->shopInfo->city ?? old('city') }}" placeholder="New York" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                    </div>
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="far fa-flag"></i>
                                        </div>
                                        <input type="text" id="state" name="state" value="{{ $provider->shopInfo->state ?? old('state') }}" placeholder="NY" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                    </div>
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal/ZIP Code</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="far fa-mailbox"></i>
                                        </div>
                                        <input type="text" id="postal_code" name="postal_code" value="{{ $provider->shopInfo->postal_code ?? old('postal_code') }}" placeholder="10001" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                    </div>
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="mt-4">
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="far fa-globe-americas"></i>
                                    </div>
                                    <input type="text" id="country" name="country" value="{{ $provider->shopInfo->country ?? old('country') }}" placeholder="United States" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                </div>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Banking & Settlement -->
                        <div class="md:col-span-2 bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                            <h3 class="font-medium text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-piggy-bank text-purple-500 mr-2"></i>
                                Banking & Settlement
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-1">Bank Account Number</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <input type="text" id="bank_account_number" name="bank_account_number" value="{{ $provider->shopInfo->bank_account_number ?? old('bank_account_number') }}" placeholder="e.g. 1234 5678 9012" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                    </div>
                                    @error('bank_account_number')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <input type="text" id="bank_name" name="bank_name" value="{{ $provider->shopInfo->bank_name ?? old('bank_name') }}" placeholder="e.g. Maybank Berhad" class="pl-10 pr-3 py-3 focus:ring-purple-500 focus:border-purple-500 block w-full border-gray-300 rounded-lg h-12 text-base">
                                    </div>
                                    @error('bank_name')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                We use these details to generate receipts and reconcile Billplz payouts.
                            </p>
                        </div>

                        <!-- Verification Status -->
                        <div class="md:col-span-2">
                            <div class="flex items-center p-4 border border-purple-200 rounded-lg bg-purple-50">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                                        <i class="fas fa-certificate text-purple-500 text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_verified" name="is_verified" value="1" {{ (isset($provider->shopInfo) && $provider->shopInfo->is_verified) || old('is_verified') ? 'checked' : '' }} class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <label for="is_verified" class="ml-2 block text-sm font-medium text-gray-900">Mark as verified vendor</label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Verified vendors are highlighted on the platform and are considered trusted partners.
                                    </p>
                                </div>
                            </div>
                            @error('is_verified')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form buttons -->
                <div class="pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.simple-providers-basic') }}" class="inline-flex justify-center items-center px-6 py-3 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm h-12">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 border border-transparent rounded-lg font-medium text-white hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors shadow-sm h-12">
                        <i class="fas fa-save mr-2"></i>
                        Save Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle form tabs with animation and styling updates
        $('.tab-button').on('click', function() {
            const tab = $(this).data('tab');

            // Update active tab button
            $('.tab-button').removeClass('active border-purple-500 text-purple-600').addClass('border-transparent text-gray-500');
            $(this).addClass('active border-purple-500 text-purple-600').removeClass('border-transparent text-gray-500');

            // Update icon backgrounds
            $('.tab-button .bg-purple-100').removeClass('bg-purple-100 text-purple-600').addClass('bg-gray-100 text-gray-500');
            $(this).find('span').removeClass('bg-gray-100 text-gray-500').addClass('bg-purple-100 text-purple-600');

            // Show selected tab content with fade effect
            $('.tab-content').fadeOut(200);
            setTimeout(function() {
                $('.tab-content').addClass('hidden');
                $(`#${tab}-tab`).removeClass('hidden').fadeIn(200);
            }, 200);
        });

        // Toggle password visibility with icon change
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const icon = $(this).find('i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Flash message auto-hide with animation
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);

        // Form validation feedback - show validation icons
        const formInputs = $('#providerForm input, #providerForm select, #providerForm textarea').not('[type="file"], [type="checkbox"]');

        formInputs.on('blur', function() {
            const input = $(this);
            const value = input.val().trim();

            if (input.prop('required') && value === '') {
                showValidationState(input, 'invalid');
            } else if (value !== '') {
                showValidationState(input, 'valid');
            } else {
                removeValidationState(input);
            }
        });

        function showValidationState(input, state) {
            // Remove any existing validation classes and elements
            removeValidationState(input);

            // Add the appropriate validation state
            if (state === 'valid') {
                input.addClass('border-green-300 pr-10');
                input.after('<div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><i class="fas fa-check-circle text-green-500"></i></div>');
            } else if (state === 'invalid') {
                input.addClass('border-red-300 pr-10');
                input.after('<div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"><i class="fas fa-exclamation-circle text-red-500"></i></div>');
            }
        }

        function removeValidationState(input) {
            input.removeClass('border-green-300 border-red-300 pr-10');
            input.parent().find('.absolute.inset-y-0.right-0').remove();
        }

        // Handle file input
        $('#profile_image').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = '<img src="' + e.target.result + '" alt="Profile Preview" class="h-full w-full object-cover">';
                    $('.h-24.w-24.rounded-full').html(imagePreview);
                }
                reader.readAsDataURL(file);
            }
        });

        // Form submission with feedback
        $('#providerForm').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();

            // Disable the button and show loading state
            submitBtn.prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Saving...');

            // Re-enable after 3 seconds if the form hasn't redirected
            // (This is a fallback in case the submission fails)
            setTimeout(function() {
                if (submitBtn.prop('disabled')) {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            }, 3000);

            return true;
        });
    });
</script>
@endsection
