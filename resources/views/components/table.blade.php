@props([
    'buttonAdd',
    'showButtonAdd' => true,
    'buttonAddText' => 'Tambah',
    'routeButtonAdd',
    'data'
])

<x-card color="gray" title="" type="custom">
    @if ($showButtonAdd)
        <div class="flex w-full justify-start p-2">
            <x-button color="gray" size="md" :buttonLink="true" :link="$routeButtonAdd">{{ $buttonAddText }}</x-button>
        </div>
    @endif

    {{ $data->table() }}
</x-card>
@push('head')
@vite(['resources/js/utils/datatable.js'])
@endpush
@push('scripts')
    {{ $data->scripts(attributes: ['type' => 'module']) }}
@endpush
