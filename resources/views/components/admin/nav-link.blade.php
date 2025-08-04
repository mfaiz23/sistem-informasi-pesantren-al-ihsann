@props(['active' => false])

@php
$classes = 'flex items-center px-6 py-3 mt-4 transition-colors duration-200 transform ';

$classes .= ($active)
            ? 'bg-green-600 text-white rounded-md'
            : 'text-gray-600 hover:bg-gray-200 hover:text-gray-800 rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($icon))
        <span class="w-6 h-6">{{ $icon }}</span>
    @endif

    <span class="mx-4 font-medium">{{ $slot }}</span>
</a>
