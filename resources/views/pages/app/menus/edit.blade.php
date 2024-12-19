@extends('layouts.app')
@section('title', 'Edit Menu')
@section('content')
<x-page title="Edit Menu" :back="true" routeBack="menus">
    <div class="flex flex-col sm:flex-row gap-3">
        <x-form routeName="{{ route('menus-edit', ['id' => $data->id]) }}" class="sm:w-1/2" shadow="drop-shadow-md">
            <x-select name="Parent" :data="$parents" valueSelected="{{ $data->parent }}"/>
            <x-input type="text" name="Name" value="{{ $data->name }}"/>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Link" desc="Default value '#'" value="{{ $data->link }}"/>
                </div>
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Link Alias" desc="Default value '#'" value="{{ $data->link_alias }}"/>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="text" name="Icon" desc="Default value '#'" value="{{ $data->icon }}"/>
                </div>
                <div class="flex flex-col w-full sm:w-1/2">
                    <x-input type="number" name="Order" desc="Default value '0'" value="{{ $data->order }}"/>
                </div>
            </div>
            <div class="flex w-full justify-end">
                <x-button type="submit" color="gray" size="md" :full="false">Submit</x-button>
            </div>
        </x-form>
        <x-preview-menu>{!! $menus !!}</x-preview-menu>
    </div>
</x-page>
@endsection
