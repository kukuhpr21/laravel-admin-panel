@extends('layouts.app')
@section('title', 'Edit Mapping User Menu')
@section('content')
<x-page title="Edit Mapping User Menu" :back="true" routeBack="{{ route('users-menus') }}">
    <x-form routeName="{{ route('users-menus-edit', ['user_id' => $user_id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-label :name="'User : '.$userName"/>

        @if ($sizeMenu > 0)
            <x-select name="Menus" :data="$menus" :multiple="true" :valueSelected="$menusSelected"/>
        @else
            <x-description-input>Menu is empty, please create new menu</x-description-input>
        @endif
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
