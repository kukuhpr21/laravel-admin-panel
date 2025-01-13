@extends('layouts.app')
@section('title', 'Tambah Mapping Role Menu Permission')
@section('content')
<x-page title="Tambah Mapping Role Menu Permission" :back="true" routeBack="{{ route('roles-menus-permissions') }}">
    <x-form routeName="{{ route('roles-menus-permissions-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        @if ($sizeRole > 0)
            <x-select name="Role" :data="$roles"/>
        @else
            <x-description-input>Role is empty, please create new role <x-button :buttonLink="true" size="sm" link="{{ route('roles-add') }}">Create</x-button></x-description-input>
        @endif

        @if ($sizeMenu > 0)
            <x-select name="Menu" :data="$menus"/>
        @else
            <x-description-input>Menu is empty, please create new menu <x-button :buttonLink="true" size="sm" link="{{ route('menus-add') }}">Create</x-button></x-description-input>
        @endif

        @if ($sizePermission > 0)
            <x-select name="Permissions" :data="$permissions" :multiple="true"/>
        @else
            <x-description-input>Permission is empty, please create new permission <x-button :buttonLink="true" size="sm" link="{{ route('permissions-add') }}">Create</x-button></x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
