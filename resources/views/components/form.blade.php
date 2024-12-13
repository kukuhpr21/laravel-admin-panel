@props(['routeName', 'class' => '', 'shadow' => 'drop-shadow-2xl', 'csrf' => true])
@php
    $baseClasses = "flex flex-col gap-3 py-3 px-4 bg-blue-50 rounded-2xl shadow-white w-full"
@endphp
<form action="{{ route($routeName) }}" method="POST" {{ $attributes->merge(['class' => "{$baseClasses} {$class} {$shadow}"])}}>
    @if ($csrf)
        @csrf
    @endif
    {{ $slot }}
</form>
