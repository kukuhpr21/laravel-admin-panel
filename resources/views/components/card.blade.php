@props([
    'color',
    'type' => 'default', //default|map|custom
    'title' => 'Card Title',
    'body' => 'Card Body',
    'description' => 'Card Description'
])
@php
    $color = `bg-$color-100`;
@endphp
<div class="{{ $color }} flex flex-col gap-3 py-7 px-5 rounded-lg hover:drop-shadow-xl" {{ $attributes }}>
    @switch($type)
        @case('custom')
            {{ $slot }}
            @break
        @case('map')

            @break
        @default
            <span class="text-lg text-gray-600 font-normal">{{ $title }}</span>
            <span class="text-2xl text-gray-600 font-semibold">{{ $slot }}</span>
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
    @endswitch
</div>
