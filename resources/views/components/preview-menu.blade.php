@props(['class' => 'w-full sm:w-1/2', 'showLabelPreview' => true])
@php
    $classes = "flex flex-col border border-dashed border-1 border-gray-400 mt-2 drop-shadow-md rounded-lg p-2";
@endphp
<div {{ $attributes->merge(['class' => "{$classes} {$class}"]) }}>
    @if ($showLabelPreview)
        <x-label name="Preview Menu"/>
    @endif
    {{ $slot }}
</div>
