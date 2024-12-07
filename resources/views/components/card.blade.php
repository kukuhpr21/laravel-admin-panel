@props([
    'color',
    'type' => 'default', //default|custom
    'title' => 'Title',
    'body' => 'Body',
    'description' => ''
])
@php
    $baseClasses = "flex flex-col gap-3 py-7 px-5  rounded-lg hover:drop-shadow-xl";
    $colorClasses = "bg-$color-100";
@endphp
<div {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses}"])}}>
    @switch($type)
        @case('custom')
            <span class="text-lg text-gray-600 font-normal">{{ $title }}</span>
            {{ $slot }}
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
        @default
            <span class="text-lg text-gray-600 font-normal">{{ $title }}</span>
            <span class="text-2xl text-gray-600 font-semibold">{{ $body }}</span>
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
    @endswitch
</div>
