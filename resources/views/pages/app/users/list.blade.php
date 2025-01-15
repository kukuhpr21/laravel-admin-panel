@extends('layouts.app')
@section('title', 'Daftar User')
@section('content')
<x-page title="Daftar User">
    <x-form routeName="{{ route('users') }}" class="sm:w-1/2 mb-4" shadow="drop-shadow-md">
        <x-label name="Filter"/>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-select name="Status" :data="$statuses"/>
            <x-select name="Role" :data="$roles"/>
        </div>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="teal" size="md">Filter</x-button>
        </div>
    </x-form>
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-add') }}" :data="$dataTable"/>
</x-page>
@endsection
