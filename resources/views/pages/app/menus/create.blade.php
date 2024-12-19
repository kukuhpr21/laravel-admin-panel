@extends('layouts.app')
@section('title', 'Tambah Menu')
@section('content')
<x-page title="Tambah Menu" :back="true" routeBack="menus">
    <div class="flex flex-col sm:flex-row gap-3">
        <x-form routeName="{{ route('menus-add') }}" class="sm:w-1/2" shadow="drop-shadow-md">
            <x-select name="Parent" :data="$parents"/>
            <x-input type="text" name="Name"/>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Link" desc="Default value '#'"/>
                </div>
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Link Alias" desc="Default value '#'"/>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Icon" desc="Default value '#'"/>
                </div>
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="number" name="Order" desc="Default value '0'"/>
                </div>
            </div>
            <div class="flex w-full justify-end">
                <x-button type="submit" color="gray" size="md" :full="false">Submit</x-button>
            </div>
        </x-form>
        <div class="w-full sm:w-1/2">
            {!! $menus !!}
        </div>
    </div>
</x-page>
@endsection
