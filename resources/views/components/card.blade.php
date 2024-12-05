@props([
    'color',
    'type' => 'default', //default|custom
    'title' => 'Title',
    'body' => 'Body',
    'description' => 'Description'
])
@php
    $color = `bg-$color-100`;
@endphp
<div class="{{ $color }} flex flex-col gap-3 py-7 px-5 rounded-lg hover:drop-shadow-xl" {{ $attributes }}>
    @switch($type)
        @case('custom')
            <span class="text-lg text-gray-600 font-normal">{{ $title }}</span>
            {{ $slot }}
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
        @default
            <span class="text-lg text-gray-600 font-normal">{{ $title }}</span>
            <span class="text-2xl text-gray-600 font-semibold">{{ $slot }}</span>
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
    @endswitch
</div>
