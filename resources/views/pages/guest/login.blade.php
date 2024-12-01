@extends('layouts.guest')
@section('title', 'Log In')
@section('content')
<x-form routeName="login" class="lg:w-1/4">
    <div class="flex justify-center w-full">
        <x-logo :showDesc="false" />
    </div>
    <x-input type="email" name="Email"/>
    <x-input type="password" name="Password" placeholder=". . . . . ."/>
    <x-button type="submit" color="gray" size="lg" :full="true">Log In</x-button>
</x-form>
@endsection
