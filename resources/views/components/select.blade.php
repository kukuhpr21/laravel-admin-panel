@props([
    'name',
    'data',
    'color' => 'slate',
    'value' => '',
    'label' => true,
    'withInvalidInput' => true,
    'desc' => '',
    'showOldValue' => true,
])

@php
    $lowerName = str_replace(" ", "_", strtolower($name));
    $baseColor = "bg-".$color."-50 focus:bg-".$color."-50";
    $classes = $baseColor.' select2 py-4 px-3 my-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-0 hover:drop-shadow-xl focus:drop-shadow-xl placeholder:italic';
    $setValue = old($lowerName);
    if (!empty($value)) {
        $setValue = $value;
    }
@endphp

<div class="flex flex-col">
    @if ($label)
        <x-label :name="$name" />
    @endif

    <select name="{{ $lowerName }}" id="{{ $lowerName }}" class="{{ $classes }}">
        @foreach ($data as $item)
            <option value=""></option>
        @endforeach
    </select>
</div>
