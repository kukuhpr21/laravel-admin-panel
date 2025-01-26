@props([
    'color',
    'type' => 'default', //default|custom
    'title' => 'Title',
    'body' => 'Body',
    'description' => '',
    'size' => 'lg',
])
@php
    $baseClasses = "flex flex-col";
    $colorClasses = "bg-$color-100";
    $sizeClasses  = match ($size) {
        'sm' => 'gap-1 py-3 px-3 rounded-md hover:drop-shadow-md',
        'md' => 'gap-2 py-5 px-3 rounded-md hover:drop-shadow-lg',
        'lg' => 'gap-3 py-7 px-5 rounded-lg hover:drop-shadow-xl',
        default => 'gap-1 py-3 px-3 rounded-md hover:drop-shadow-md',
    };
    $titleTextClasses  = match ($size) {
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        default => 'text-sm',
    };
@endphp
<div {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses} {$sizeClasses}"])}}>
    @switch($type)
        @case('custom')
            <span class="{{ $titleTextClasses }} text-gray-600 font-normal">{{ $title }}</span>
            {{ $slot }}
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
        @default
            <span class="{{ $titleTextClasses }} text-gray-600 font-normal">{{ $title }}</span>
            <span class="text-2xl text-gray-600 font-semibold">{{ $body }}</span>
            <span class="text-sm text-gray-400 font-normal">{{ $description }}</span>
            @break
    @endswitch
</div>
