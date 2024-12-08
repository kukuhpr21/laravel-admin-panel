@extends('layouts.app')
@section('title', 'Daftar Role')
@section('content')
<x-page title="Daftar Role">
    <x-card color="gray" title="" type="custom">
        {{ $dataTable->table() }}
    </x-card>
</x-page>
@endsection
@push('head')
@vite(['resources/js/utils/datatable.js'])
@endpush
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
