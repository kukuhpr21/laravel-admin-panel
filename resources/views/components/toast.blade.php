@php
    $theme = match(session('toast.status')) {
        'success' => 'border border-teal-300 bg-teal-100',
        'warning' => 'border border-yellow-300 bg-yellow-100',
        'error'   => 'border border-red-300 bg-red-100',
        default   => 'border border-blue-300 bg-blue-100',
    };

    $icon = match(session('toast.status')) {
        'success' => '<i class="ri-checkbox-circle-line ri-lg"></i>',
        'warning' => '<i class="ri-error-warning-line ri-lg"></i>',
        'error'   => '<i class="ri-close-circle-line ri-lg"></i>',
        default   => '<i class="ri-information-line ri-lg"></i>',
    };

    $bgIcon = match(session('toast.status')) {
        'success' => 'bg-teal-600',
        'warning' => 'bg-yellow-600',
        'error'   => 'bg-red-600',
        default   => 'bg-blue-600',
    };

    $text = match(session('toast.status')) {
        'success' => 'text-teal-700',
        'warning' => 'text-yellow-700',
        'error'   => 'text-red-700',
        default   => 'text-blue-800',
    };

    $baseClasses = "absolute top-2 right-2 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs rounded-xl shadow-lg";
@endphp
@if (session()->has('toast'))
    <div id="dismiss-toast" {{ $attributes->merge(['class' => "{$baseClasses} {$theme}"])}} role="alert" tabindex="-1" aria-labelledby="hs-toast-dismiss-button-label">
        <div class="flex p-4 gap-2">

            <span {{ $attributes->merge(['class' => "inline-flex justify-center items-center size-[46px] rounded-full text-white {$bgIcon}"])}}>
                {!! $icon !!}
            </span>

            <p id="hs-toast-dismiss-button-label"  {{ $attributes->merge(['class' => "text-sm {$text}"])}}>
                {{ session('toast.message') }}
            </p>

            <div class="ms-auto">
                <button type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100" aria-label="Close" data-hs-remove-element="#dismiss-toast">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
