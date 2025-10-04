@php($items = $breadcrumbs ?? [])

@if(count($items))
<nav aria-label="Breadcrumb" class="text-sm text-gray-500">
    <ol class="flex items-center gap-2">
        @php($lastIndex = count($items) - 1)
        @foreach($items as $index => $item)
            @php(
                $isLast = $index === $lastIndex
            )
            <li class="flex items-center gap-2">
                @if(!$isLast && !empty($item['url']))
                    <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1 font-medium text-teal-600 hover:text-teal-700 transition-colors">
                        @if(($item['icon'] ?? null) === 'home' || ($item['icon'] ?? null) === null && $index === 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        @elseif(!empty($item['icon']) && $item['icon'] !== 'home')
                            {!! $item['icon'] !!}
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                @else
                    <span class="inline-flex items-center gap-1 font-medium text-gray-600">
                        @if(($item['icon'] ?? null) === 'home' || ($item['icon'] ?? null) === null && $index === 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        @elseif(!empty($item['icon']) && $item['icon'] !== 'home')
                            {!! $item['icon'] !!}
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </span>
                @endif

                @if(!$isLast)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
