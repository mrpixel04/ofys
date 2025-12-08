@props(['active' => false, 'href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => ($active ? 'border-yellow-500 text-yellow-700 bg-yellow-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300') . ' block pl-3 pr-4 py-2 border-l-4 text-base font-medium']) }}>
    {{ $slot }}
</a>
