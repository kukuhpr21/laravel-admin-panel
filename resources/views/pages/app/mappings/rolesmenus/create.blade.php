@extends('layouts.app')
@section('title', 'Tambah Mapping Role Menu')
@section('content')
<x-page title="Tambah Mapping Role Menu" :back="true" routeBack="{{ route('roles-menus') }}">
    <x-form routeName="{{ route('roles-menus-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        @if ($sizeRole > 0)
            <x-select name="Role" :data="$roles"/>
        @else
            <x-description-input>All role has been mapped</x-description-input>
        @endif

        @if ($sizeMenu > 0)
            <x-select name="Menus" :data="$menus" :multiple="true"/>
        @else
            <x-description-input>Menu is empty, please create new menu</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
