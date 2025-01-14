@extends('layouts.app')
@section('title', 'Edit Status')
@section('content')
<x-page title="Edit Status" :back="true" routeBack="{{ route('statuses') }}">
    <x-form routeName="{{ route('statuses-edit', ['id' => $data->id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name" value="{{ $data->name }}"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
