@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<x-page title="Edit User" :back="true" routeBack="{{ route('users-roles') }}">
    <x-form routeName="{{ route('users-edit', ['user_id' => $user_id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-label :name="'User : '.$userName"/>

        @if ($sizeRole > 0)
            <x-select name="Roles" :data="$roles" :multiple="true" :valueSelected="$rolesSelected"/>
        @else
            <x-description-input>Role is empty, please create new role</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
