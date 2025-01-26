@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<x-page title="Edit User" :back="true" routeBack="{{ route('users-roles') }}">
    <x-form routeName="{{ route('users-edit', ['id' => $data->id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name" :value="$data->name"/>
        <x-input type="email" name="Email" :value="$data->email"/>
        <x-select name="Roles" :data="$roles" :multiple="true" :valueSelected="$rolesSelected"/>

        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
