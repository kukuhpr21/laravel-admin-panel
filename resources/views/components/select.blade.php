@props([
    'name',
    'data',
    'color' => 'slate',
    'valueSelected' => '',
    'label' => true,
    'withInvalidInput' => true,
    'desc' => '',
])

@php
    $lowerName = str_replace(" ", "_", strtolower($name));
    $baseColor = "bg-".$color."-50 focus:bg-".$color."-50";
    $classes   = $baseColor.' select2';
@endphp

<div class="flex flex-col">
    @if ($label)
        <x-label :name="$name" />
    @endif

    <select name="{{ $lowerName }}" id="{{ $lowerName }}" class="{{ $classes }}">
        @foreach ($data as $item)
            <option value="{{ $item['value'] }}" {{ (!empty($valueSelected) && $item['value'] == $valueSelected) ? 'selected' : '' }}>{{ $item['text'] }}</option>
        @endforeach
    </select>

    @if (!empty($desc))
        <x-description-input>{{ $desc }}</x-description-input>
    @endif

    @if ($withInvalidInput)
        @error($lowerName)
            <x-invalid-input>{{$message}}</x-invalid-input>
        @enderror
    @endif
</div>
