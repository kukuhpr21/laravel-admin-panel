@extends('layouts.app')
@section('title', 'Daftar User')
@section('content')
<x-page title="Daftar User">
    <x-form routeName="{{ route('users') }}" class="sm:w-1/2 mb-4" shadow="drop-shadow-md">
        <x-label name="Filter"/>
        <div id="section_filter" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <x-select name="Status" :data="$statuses" :valueSelected="$status"/>
            <x-select name="Role" :data="$roles" :valueSelected="$role"/>
            <x-input type="date" name="Created At"/>
        </div>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="teal" size="md">Filter</x-button>
        </div>
    </x-form>
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-add') }}" :data="$dataTable"/>
</x-page>
@endsection
@push('scripts')
@vite(['resources/js/modules/users/list.js'])
@endpush
