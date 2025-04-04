<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('admin.settings') }}</h1>
            <p class="text-lg text-gray-600">{{ __('admin.settings_description') }}</p>

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

        <!-- Settings Tabs -->
        <div x-data="{ tab: 'language' }">
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <button
                            @click="tab = 'language'"
                            :class="{ 'border-purple-600 text-purple-600': tab === 'language', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'language' }"
                            class="inline-block py-4 px-4 text-sm font-medium focus:outline-none border-b-2"
                        >
                            {{ __('admin.language_settings') }}
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Language Settings Tab -->
            <div x-show="tab === 'language'" class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                    <h2 class="text-xl font-bold">{{ __('admin.language_settings') }}</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.settings.language') }}" method="post">
                        @csrf

                        <div class="mb-6">
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.admin_language') }}</label>
                            <div class="relative">
                                <select id="language" name="language" class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 rounded-md">
                                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ms" {{ session('locale') == 'ms' ? 'selected' : '' }}>Bahasa Malaysia</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">{{ __('admin.language_help_text') }}</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                                {{ __('admin.save_changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
