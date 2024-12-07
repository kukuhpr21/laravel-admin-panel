<div class="grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 lg:gap-4 gap-6 lg:px-0 px-2">
    <x-card color="blue" type="custom" title="Chart">
        <canvas id="myChart" class="flex w-full"></canvas>
    </x-card>
    <x-card color="yellow" type="custom" title="Map" description="Map in London">
        <div id="map" class="flex min-h-80 w-full"></div>
    </x-card>
</div>
@push('head')
@vite(['resources/js/utils/chart.js', 'resources/js/utils/leaflet.js'])
@endpush
@push('scripts')
@vite(['resources/js/modules/dashboard/index.js'])
@endpush
