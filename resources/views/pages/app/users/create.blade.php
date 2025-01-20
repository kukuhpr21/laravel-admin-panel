@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<x-page title="Tambah User" :back="true" routeBack="{{ route('users') }}">
    <x-form routeName="{{ route('users-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name"/>
        <x-input type="email" name="Email"/>
        <x-select name="Roles" :data="$roles" :multiple="true"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md" :full="false">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
