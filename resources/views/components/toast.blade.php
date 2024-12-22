@props(['position' => 'tr'])

@if (session()->has('toast'))

    @php
        $toastPosition = match ($position) {
            'tl' => 'absolute top-4 left-4',
            'br' => 'absolute bottom-4 right-4',
            'bl' => 'absolute bottom-4 left-4',
            default => 'absolute top-4 right-4',
        };
    @endphp

    <div {{ $attributes->merge(['class' => "{$toastPosition} flex flex-col gap-2"])}}>

        @if (session('toast.status'))
            <x-toast-item status="{{ session('toast.status') }}" message="{{ session('toast.message') }}" dismissToastID="dismiss-toast"/>
        @else

            @for ($i = 0; $i < count(session('toast')); $i++)
                @php
                    $toast          = session('toast')[$i];
                    $dismissToastID = 'dismiss-toast-'.$i;
                @endphp

                <x-toast-item status="{{ $toast['status'] }}" message="{{ $toast['message'] }}" dismissToastID="{{ $dismissToastID }}"/>
            @endfor
        @endif

    </div>

@endif
