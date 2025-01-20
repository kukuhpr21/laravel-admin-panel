@props(['routeName', 'classForm' => '', 'classFilter', 'shadow' => 'drop-shadow-2xl', 'csrf' => true])
<x-form :routeName="$routeName" :class="$classForm" shadow="drop-shadow-md" :csrf="$csrf">
    <x-label name="Filter"/>
    <div id="section_filter" class="{{ $classFilter }}">
        {{ $slot }}
    </div>
    <div class="flex w-full justify-end">
        <x-button type="submit" color="teal" size="md">Filter</x-button>
    </div>
</x-form>
