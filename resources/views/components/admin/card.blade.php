@props(['title', 'value', 'icon' => ''])

<div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
    <div class="flex items-center">
        @if ($icon)
        <div class="p-3 bg-green-100 rounded-full">
            {!! $icon !!} {{-- Gunakan {!! !!} untuk merender SVG --}}
        </div>
        @endif
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
        </div>
    </div>
</div>
