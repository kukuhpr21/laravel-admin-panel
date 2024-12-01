@props(['type', 'color' => 'blue', 'size' => '', 'full' => false])
@php
$baseClasses = 'hover:shadow-xl my-3';

$colorClasses = "bg-$color-500 text-white hover:bg-$color-600";
// $colorClasses = match ($color) {
//     'slate' => 'bg-slate-500 text-white hover:bg-slate-600',
//     'blue' => 'bg-blue-500 text-white hover:bg-blue-600',
//     'red' => 'bg-red-500 text-white hover:bg-red-600',
//     'green' => 'bg-green-500 text-white hover:bg-green-600',
//     'gray' => 'bg-gray-500 text-white hover:bg-gray-600',
//     'teal' => 'bg-teal-500 text-white hover:bg-teal-600',
//     'yellow' => 'bg-yellow-500 text-white hover:bg-yellow-600',
//     default => 'bg-blue-500 text-white hover:bg-blue-600',
// };


$sizeClasses = match ($size) {
    'sm' => 'px-3 py-2 text-sm font-normal rounded-md',
    'md' => 'px-4 py-3 text-base font-medium rounded-lg',
    'lg' => 'px-6 py-5 text-lg font-semibold rounded-2xl',
    default => 'px-4 py-2 text-base font-medium',
};

$widthClasses = $full ? 'w-full' : 'w-fit';

@endphp
<button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses} {$sizeClasses} {$widthClasses}"]) }}>{{ $slot }}</button>
