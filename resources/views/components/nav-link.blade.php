@props(['active' => false, 'href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => ($active ? 'border-yellow-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300') . ' inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium']) }}>
    {{ $slot }}
</a>
