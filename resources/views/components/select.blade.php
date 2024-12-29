@props([
    'name',
    'data',
    'color' => 'slate',
    'valueSelected' => '',
    'label' => true,
    'withInvalidInput' => true,
    'desc' => '',
    'multiple' => false,
])

@php
    $lowerName    = str_replace(" ", "_", strtolower($name));
    $baseColor    = "bg-".$color."-50 focus:bg-".$color."-50";
    $classes      = $baseColor.' select2';
    $isMultiple   = $multiple ? 'multiple' : '';
    $nameSelect   = $multiple ? $lowerName.'[]' : $lowerName;
@endphp

<div class="flex flex-col">
    @if ($label)
        <x-label :name="$name" />
    @endif

    <select name="{{ $nameSelect }}" id="{{ $lowerName }}" class="{{ $classes }}" {{ $isMultiple }}>
        @if (count($data) > 0)

            @php
                $valueSelectedItem = $valueSelected;
            @endphp
            @if ($multiple)
                @foreach ($data as $item)
                    @php
                        $isSelected = '';
                    @endphp

                    @if (!empty($valueSelected))

                        @foreach ($valueSelected as $vs)
                            @php
                                $isSelected = (!empty($vs) && $item['value'] == $vs->id) ? 'selected' : '';
                            @endphp
                            @if ($isSelected == 'selected')
                                @break;
                            @endif
                        @endforeach

                    @endif
                    <option value="{{ $item['value'] }}" {{ $isSelected }}>{{ $item['text'] }}</option>
                @endforeach
            @else
                @foreach ($data as $item)
                    <option value="{{ $item['value'] }}" {{ (!empty($valueSelected) && $item['value'] == $valueSelected) ? 'selected' : '' }}>{{ $item['text'] }}</option>
                @endforeach
            @endif

        @endif
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
