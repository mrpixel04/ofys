<x-app-layout>
    <div class="bg-gray-50 py-12 sm:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">Livewire Test Page</h1>

            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <livewire:counter />
            </div>

            <div class="text-center">
                <a href="{{ url('/') }}" class="text-yellow-500 hover:text-yellow-600 font-medium">Back to Home</a>
            </div>
        </div>
    </div>
</x-app-layout>
