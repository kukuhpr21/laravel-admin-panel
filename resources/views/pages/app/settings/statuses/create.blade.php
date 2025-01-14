@extends('layouts.app')
@section('title', 'Tambah Status')
@section('content')
<x-page title="Tambah Status" :back="true" routeBack="{{ route('statuses') }}">
    <x-form routeName="{{ route('statuses-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
        <x-input type="text" name="Name"/>
        <div class="flex w-full justify-end">
            <x-button type="submit" color="gray" size="md">Submit</x-button>
        </div>
    </x-form>
</x-page>
@endsection
