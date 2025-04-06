<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('admin.profile') }}</h1>
            <p class="text-lg text-gray-600">{{ __('admin.update_profile_description') }}</p>

            @if(session('success'))
                <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($error))
                <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    {{ $error }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <h2 class="text-xl font-bold">{{ __('admin.update_profile') }}</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Name') }}</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? old('name') }}"
                                   class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? old('email') }}"
                                   class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                            @error('email')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                                {{ __('admin.update_profile') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <h2 class="text-xl font-bold">{{ __('admin.update_password') }}</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.current_password') }}</label>
                            <input type="password" id="current_password" name="current_password"
                                   class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                            @error('current_password')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.new_password') }}</label>
                            <input type="password" id="password" name="password"
                                   class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                            @error('password')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.confirm_password') }}</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="block w-full px-4 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                                {{ __('admin.update_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
