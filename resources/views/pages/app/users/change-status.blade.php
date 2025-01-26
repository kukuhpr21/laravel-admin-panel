@extends('layouts.app')
@section('title', 'Change Status User')
@section('content')
<x-page title="Change Status User" :back="true" routeBack="{{ route('users') }}">
    <x-form routeName="{{ route('users-change-status', ['id' => $data->id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-card color="gray" type="custom" title="Name" size="sm">
            <x-label :name="$data->name"/>
        </x-card>
        <x-select name="Status" :data="$statuses" :valueSelected="$data->status_id"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
