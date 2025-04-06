<div class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Livewire Counter</h2>
    <div class="flex items-center space-x-4">
        <button wire:click="decrement" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
            -
        </button>
        <span class="text-xl font-bold text-gray-800 dark:text-white">{{ $count }}</span>
        <button wire:click="increment" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
            +
        </button>
    </div>
</div>
