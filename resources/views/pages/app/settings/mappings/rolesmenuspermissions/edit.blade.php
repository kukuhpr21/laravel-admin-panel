@extends('layouts.app')
@section('title', 'Edit Mapping Role Menu Permission')
@section('content')
<x-page title="Edit Mapping Role Menu Permission" :back="true" routeBack="{{ route('roles-menus-permissions') }}">
    <x-form routeName="{{ route('roles-menus-permissions-edit', ['role_id' => $role_id, 'menu_id' => $menu_id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-card color="slate" type="custom" title="Role" size="sm">
            <x-label :name="$roleName"/>
        </x-card>

        <x-card color="slate" type="custom" title="Menu" size="sm">
            <x-label :name="$menuName"/>
        </x-card>

        @if ($sizePermission > 0)
            <x-select name="Permissions" :data="$permissions" :multiple="true" :valueSelected="$permissionsSelected"/>
        @else
            <x-description-input>Permission is empty, please create new permission</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
