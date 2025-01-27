@extends('layouts.guest')
@section('title', 'Change Password')
@section('content')
<x-form routeName="{{ route('auth-change-password') }}" class="lg:w-1/4 mx-3 sm:mx-0">
    <div class="flex justify-center w-full">
        <x-logo :showDesc="false" />
    </div>
    <x-input type="email" name="Email"/>
    <x-input type="password" name="New Password" placeholder=". . . . . ."/>
    <x-input type="password" name="Confirm Password" placeholder=". . . . . ."/>
    <x-button type="submit" color="teal" size="lg" :full="true">Change Password</x-button>
    <a href="{{ route('login') }}" class="flex w-full justify-center font-semibold text-slate-600 bg-transparent hover:bg-blue-100 hover:rounded-lg hover:drop-shadow-lg p-5">Log In</a>
</x-form>
@endsection
