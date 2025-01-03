@extends('layouts.app')
@section('title', 'Tambah Mapping Menu Permission')
@section('content')
<x-page title="Tambah Mapping Menu Permission" :back="true" routeBack="{{ route('menus-permissions') }}">
    <x-form routeName="{{ route('menus-permissions-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        @if ($sizeMenu > 0)
            <x-select name="Menu" :data="$menus"/>
        @else
            <x-description-input>All menu has been mapped</x-description-input>
        @endif

        @if ($sizePermission > 0)
            <x-select name="Permissions" :data="$permissions" :multiple="true"/>
        @else
            <x-description-input>Permission is empty, please create new permission</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
