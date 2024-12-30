@extends('layouts.app')
@section('title', 'Tambah Mapping User Role')
@section('content')
<x-page title="Tambah Mapping User Role" :back="true" routeBack="{{ route('users-roles') }}">
    <x-form routeName="{{ route('users-roles-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        @if ($sizeUser > 0)
            <x-select name="User" :data="$users"/>
        @else
            <x-description-input>All user has been mapped</x-description-input>
        @endif

        @if ($sizeRole > 0)
            <x-select name="Roles" :data="$roles" :multiple="true"/>
        @else
            <x-description-input>Role is empty, please create new role</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
