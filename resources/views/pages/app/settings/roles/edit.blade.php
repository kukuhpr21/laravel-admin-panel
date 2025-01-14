@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
<x-page title="Edit Role" :back="true" routeBack="{{ route('roles') }}">
    <x-form routeName="{{ route('roles-edit', ['id' => $data->id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name" value="{{ $data->name }}"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
