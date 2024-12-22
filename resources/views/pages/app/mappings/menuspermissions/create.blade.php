@extends('layouts.app')
@section('title', 'Tambah Role')
@section('content')
<x-page title="Tambah Mapping Menu Permission" :back="true" routeBack="{{ route('menus-permissions') }}">
    <x-form routeName="{{ route('menus-permissions-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-select name="Menu" :data="$menus"/>
        <x-select name="Permissions" :data="$permissions"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
