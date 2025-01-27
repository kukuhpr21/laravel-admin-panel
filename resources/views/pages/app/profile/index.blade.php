@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<x-page title="Profile">
    <div class="flex flex-col bg-blue-50">
        <div class="relative rounded-t-2xl h-[100px] bg-blue-100">
            <span class="flex size-[70px] sm:size-[100px] items-center justify-center text-gray-800 bg-gray-300 rounded-full absolute -bottom-7 sm:-bottom-10 left-[5%] sm:left-[2%] sm:right-0">
                <i class="ri-user-line ri-2x"></i>
            </span>
        </div>
        <div class="flex flex-col sm:flex-row mt-10 gap-2 mr-4 sm:mr-0">
            <x-form routeName="{{ route('change-profile', ['id' => $data->id]) }}" class="w-full sm:w-1/2 bg-white m-2" shadow="drop-shadow-none">
                <x-label name="Biodata"/>
                <div class="flex flex-col gap-2">
                    <x-input type="text" name="Name" :value="$data->name"/>
                    <x-input type="email" name="Email" :value="$data->email"/>
                    <div class="flex w-full justify-end">
                        <x-button type="submit" color="blue" size="md" :full="false">Save</x-button>
                    </div>
                </div>
            </x-form>
            <x-form routeName="{{ route('change-password', ['id' => $data->id]) }}" class="w-full sm:w-1/2 bg-white m-2" shadow="drop-shadow-none">
                <x-label name="Change Password"/>
                <div class="flex flex-col gap-2">
                    <x-input type="password" name="New Password"/>
                    <x-input type="password" name="Confirm Password"/>
                    <div class="flex w-full justify-end">
                        <x-button type="submit" color="blue" size="md" :full="false">Change Password</x-button>
                    </div>
                </div>
            </x-form>
        </div>
    </div>
</x-page>
@endsection
