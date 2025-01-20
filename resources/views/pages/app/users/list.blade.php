@extends('layouts.app')
@section('title', 'Daftar User')
@section('content')
<x-page title="Daftar User">
    <x-form-filter routeName="{{ route('users') }}" classForm="sm:w-1/2 mb-4" classFilter="grid grid-cols-1 sm:grid-cols-3 gap-3" shadow="drop-shadow-md">
        <x-select name="Status" :data="$statuses" :valueSelected="$status"/>
        <x-select name="Role" :data="$roles" :valueSelected="$role"/>
        <x-input type="date" name="Created At" :value="$createdAt"/>
    </x-form-filter>
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-add') }}" :data="$dataTable"/>
</x-page>
@endsection
@push('scripts')
@vite(['resources/js/modules/users/list.js'])
@endpush
