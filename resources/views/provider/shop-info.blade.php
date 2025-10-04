@extends('layouts.provider.simple-app')

@section('header', 'Shop Information')

@section('breadcrumbs')
    @include('layouts.partials.breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('provider.dashboard')],
            ['label' => 'Shop Information'],
        ],
    ])
@endsection

@section('header_subtitle')
    Keep your provider profile polished so customers know exactly who they are booking.
@endsection

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-teal-500 to-emerald-600 rounded-t-xl p-8 text-white">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 rounded-lg p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Shop Information</h1>
                    <p class="text-teal-100 mt-1">Manage your business details and contact information</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-b-xl shadow-xl overflow-hidden">
            <form method="POST" action="{{ route('provider.shop-info.update') }}" enctype="multipart/form-data" class="p-8">
                @csrf

                <!-- Basic Information -->
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Basic Information
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">Company Name *</label>
                            <input type="text" id="company_name" name="company_name"
                                value="{{ old('company_name', $shopInfo->company_name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="Enter your company name"
                                required>
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="company_email" class="block text-sm font-semibold text-gray-700 mb-2">Company Email *</label>
                            <input type="email" id="company_email" name="company_email"
                                value="{{ old('company_email', $shopInfo->company_email ?? Auth::user()->email) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="company@example.com"
                                required>
                            @error('company_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Business Description</label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base resize-none"
                                placeholder="Describe your business, services, and what makes you unique...">{{ old('description', $shopInfo->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Business Images
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Company Logo</label>
                            @if($shopInfo && $shopInfo->logo)
                                <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('storage/' . $shopInfo->logo) }}" alt="Current Logo" class="h-16 w-16 object-cover rounded-lg border border-gray-300">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ basename($shopInfo->logo) }}</p>
                                            <p class="text-xs text-gray-500">Upload a new image to replace</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <input type="file" id="logo" name="logo" accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <p class="mt-1 text-sm text-gray-500">Recommended: Square image (400x400px) in JPG, PNG format. Max 2MB.</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shop_image" class="block text-sm font-semibold text-gray-700 mb-2">Shop Image</label>
                            @if($shopInfo && $shopInfo->shop_image)
                                <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-600 mb-2">Current Shop Image:</p>
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('storage/' . $shopInfo->shop_image) }}" alt="Current Shop Image" class="h-16 w-24 object-cover rounded-lg border border-gray-300">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ basename($shopInfo->shop_image) }}</p>
                                            <p class="text-xs text-gray-500">Upload a new image to replace</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <input type="file" id="shop_image" name="shop_image" accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <p class="mt-1 text-sm text-gray-500">Recommended: Wide image (1200x600px) showcasing your business. Max 2MB.</p>
                            @error('shop_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Contact Information
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $shopInfo->phone ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="+60 12-345 6789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                            <input type="url" id="website" name="website"
                                value="{{ old('website', $shopInfo->website ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="https://www.yourwebsite.com">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mb-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Business Address
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                            <input type="text" id="address" name="address"
                                value="{{ old('address', $shopInfo->address ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="123 Main Street">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" id="city" name="city"
                                value="{{ old('city', $shopInfo->city ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="Kuala Lumpur">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                            <select id="state" name="state"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base">
                                <option value="">Select State</option>
                                <option value="Johor" {{ old('state', $shopInfo->state ?? '') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ old('state', $shopInfo->state ?? '') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ old('state', $shopInfo->state ?? '') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                <option value="Kuala Lumpur" {{ old('state', $shopInfo->state ?? '') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                <option value="Labuan" {{ old('state', $shopInfo->state ?? '') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                <option value="Melaka" {{ old('state', $shopInfo->state ?? '') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                <option value="Negeri Sembilan" {{ old('state', $shopInfo->state ?? '') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                <option value="Pahang" {{ old('state', $shopInfo->state ?? '') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Penang" {{ old('state', $shopInfo->state ?? '') == 'Penang' ? 'selected' : '' }}>Penang</option>
                                <option value="Perak" {{ old('state', $shopInfo->state ?? '') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ old('state', $shopInfo->state ?? '') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Putrajaya" {{ old('state', $shopInfo->state ?? '') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                                <option value="Sabah" {{ old('state', $shopInfo->state ?? '') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ old('state', $shopInfo->state ?? '') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ old('state', $shopInfo->state ?? '') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                <option value="Terengganu" {{ old('state', $shopInfo->state ?? '') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                            </select>
                            @error('state')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-2">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code"
                                value="{{ old('postal_code', $shopInfo->postal_code ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                placeholder="50000">
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                            <input type="text" id="country" name="country"
                                value="{{ old('country', $shopInfo->country ?? 'Malaysia') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-colors text-base"
                                readonly>
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-4 space-y-3 sm:space-y-0 pt-6 border-t border-gray-200">
                    <button type="reset" class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                        Reset Form
                    </button>
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Shop Information
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
