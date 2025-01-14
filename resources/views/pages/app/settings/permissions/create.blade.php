@extends('layouts.app')
@section('title', 'Tambah Permission')
@section('content')
<x-page title="Tambah Permission" :back="true" routeBack="{{ route('permissions') }}">
    <x-form routeName="{{ route('permissions-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
