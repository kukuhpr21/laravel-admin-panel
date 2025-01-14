@extends('layouts.app')
@section('title', 'Tambah Role')
@section('content')
<x-page title="Tambah Role" :back="true" routeBack="{{ route('roles') }}">
    <x-form routeName="{{ route('roles-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name"/>
        <x-select name="List Role Available" :data="$roles" :multiple="true"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
