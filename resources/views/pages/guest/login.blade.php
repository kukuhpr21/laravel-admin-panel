@extends('layouts.guest')
@section('title', 'Log In')
@section('content')
<x-form routeName="{{ route('login') }}" class="lg:w-1/4 mx-3 sm:mx-0">
    <div class="flex justify-center w-full">
        <x-logo :showDesc="false" />
    </div>
    <x-input type="email" name="Email"/>
    <x-input type="password" name="Password" placeholder=". . . . . ."/>
    <x-button type="submit" color="gray" size="lg" :full="true">Log In</x-button>
    <a href="{{ route('auth-change-password') }}" class="flex w-full justify-center font-semibold text-slate-600 bg-transparent hover:bg-blue-100 hover:rounded-lg hover:drop-shadow-lg p-5">Change Password</a>
</x-form>
@endsection
