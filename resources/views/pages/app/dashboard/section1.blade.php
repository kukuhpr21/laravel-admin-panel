<div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 lg:gap-4 gap-6 lg:px-0 px-2">
    @php
        $items = [
            [
                'color' => 'teal',
                'title' => 'Total Penjualan',
                'body' => 'Rp 1jt'
            ],
            [
                'color' => 'gray',
                'title' => 'Total Pembelian',
                'body' => 'Rp 2jt'
            ],
            [
                'color' => 'gray',
                'title' => 'Total Barang',
                'body' => '100'
            ],
            [
                'color' => 'gray',
                'title' => 'Keuntungan',
                'body' => 'Rp 5jt'
            ],
        ];
    @endphp

    @foreach ($items as $item)
        <x-card color="{{ $item['color'] }}" title="{{ $item['title'] }}" body="{{ $item['body'] }}" description=""/>
    @endforeach
</div>
