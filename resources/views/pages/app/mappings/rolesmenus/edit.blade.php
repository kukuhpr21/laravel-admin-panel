@extends('layouts.app')
@section('title', 'Edit Mapping Role Menu')
@section('content')
<x-page title="Edit Mapping Role Menu" :back="true" routeBack="{{ route('roles-menus') }}">
    <x-form routeName="{{ route('roles-menus-edit', ['role_id' => $role_id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-label :name="'Role : '.$roleName"/>

        @if ($sizeMenu > 0)
            <x-select name="menus" :data="$menus" :multiple="true" :valueSelected="$menusSelected"/>
        @else
            <x-description-input>menu is empty, please create new menu</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
