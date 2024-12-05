@props(['showDesc' => true])
@php
    $name = ucwords(config('app.name'));
    $letter = strtoupper(substr($name, 0, 1));
    $show = $showDesc ? '' : 'hidden';
@endphp
<div class="flex flex-row items-center p-2">
    <span class="font-bold text-xl text-white bg-gray-600 rounded-md px-4 py-2">{{ $letter }}</span>
    <span class="font-semibold text-lg text-gray-600 pl-2 overflow-hidden text-ellipsis whitespace-normal max-h-[4rem] line-clamp-2 {{ $show }}">{{ $name }}</span>
</div>
