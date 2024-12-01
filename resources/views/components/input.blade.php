@props([
    'type',
    'placeholder' => '',
    'name',
    'color' => 'slate',
    'value' => '',
    'label' => true,
    'withInvalidInput' => true,
    'desc' => '',
])

@php
    $lowerName = str_replace(" ", "_", strtolower($name));
    $baseColor = "bg-".$color."-50 focus:bg-".$color."-50";
    $classes = $baseColor.' py-4 px-3 my-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-0 hover:drop-shadow-xl focus:drop-shadow-xl placeholder:italic';
@endphp

<div class="flex flex-col">
    @if ($label)
        <x-label :name="$name" />
    @endif

    @if ($type != 'password')
        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            name="{{ $lowerName }}"
            id="{{ $lowerName }}"
            class="{{ $classes }}"
            value="{{ $value }}">
    @else
        <div class="flex flex-row gap-1">
            <input
                id="hs-toggle-password"
                type="{{ $type }}"
                placeholder="{{ $placeholder }}"
                name="{{ $lowerName }}"
                id="{{ $lowerName }}"
                class="{{ $classes }} w-4/5"
                value="{{ $value }}">

            <button type="button" data-hs-toggle-password='{
                "target": "#hs-toggle-password"
                }' class="border border-slate-300 bg-{{$color}}-50 hover:bg-slate-100 hover:drop-shadow-xl focus:ring-0 w-1/5 flex items-center justify-center z-20 px-3 my-3 cursor-pointer text-gray-400 rounded-2xl focus:outline-none">
                <x-icon-toggle-password/>
            </button>
        </div>
    @endif

    @if (!empty($desc))
        <x-description-input>{{ $desc }}</x-description-input>
    @endif

    @if ($withInvalidInput)
        @error($lowerName)
            <x-invalid-input>{{$message}}</x-invalid-input>
        @enderror
    @endif
</div>
