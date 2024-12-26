@props([
    'type' => 'button',
    'color' => 'blue',
    'size' => '',
    'full' => false,
    'buttonLink' => false,
    'link' => '',
])
@php
$baseClasses = 'hover:shadow-xl my-3 disabled:hover:shadow-none';

$colorClasses = match ($color) {
    'gray' => "bg-gray-500 text-white hover:bg-gray-600 disabled:hover:bg-gray-500",
    'red' => "bg-red-500 text-white hover:bg-red-600 disabled:hover:bg-red-500",
    'yellow' => "bg-yellow-500 text-white hover:bg-yellow-600 disabled:hover:bg-yellow-500",
    default => "bg-blue-500 text-white hover:bg-blue-600 disabled:hover:bg-blue-500",
};

$sizeClasses = match ($size) {
    'sm' => 'px-3 py-2 text-sm font-normal rounded-md',
    'md' => 'px-4 py-3 text-base font-medium rounded-lg',
    'lg' => 'px-6 py-5 text-lg font-semibold rounded-2xl',
    default => 'px-4 py-2 text-base font-medium',
};

$widthClasses = $full ? 'w-full' : 'w-fit';

@endphp
@if (!$buttonLink)
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses} {$sizeClasses} {$widthClasses}"]) }}>{{ $slot }}</button>
@else
    <a href="{{ $link }}" {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses} {$sizeClasses} {$widthClasses}"]) }}>{{ $slot }}</a>
@endif
