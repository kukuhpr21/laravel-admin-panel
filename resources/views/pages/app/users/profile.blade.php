@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<x-page title="Profile">
    <x-form routeName="#" shadow="drop-shadow-md">
        <div class="flex flex-col">
            <div class="relative rounded-t-2xl h-[100px] bg-blue-100">
                <span class="flex size-[70px] sm:size-[100px] items-center justify-center text-gray-800 bg-gray-300 rounded-full absolute -bottom-7 sm:-bottom-10 left-[5%] sm:left-[2%] sm:right-0">
                    <i class="ri-user-line lg:ri-2xl ri-lg"></i>
                </span>
            </div>
            <div class="flex flex-col mt-10 w-full sm:w-1/2 gap-2">
                <x-input type="text" name="Name" :value="$data->name"/>
                <x-input type="email" name="Email" :value="$data->email"/>
                <div class="flex w-full justify-end">
                    <x-button type="submit" color="blue" size="md" :full="false">Submit</x-button>
                </div>
            </div>
        </div>
    </x-form>
</x-page>
@endsection
