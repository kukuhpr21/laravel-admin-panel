@extends('layouts.guest')
@section('title', 'Choose Role')
@section('content')
<x-form routeName="choose-role" class="lg:w-1/4 mx-3 sm:mx-0">
    <div class="flex justify-center w-full">
        <x-logo :showDesc="false" />
    </div>
    <x-input type="email" name="Email"/>
    <x-input type="password" name="Password" placeholder=". . . . . ."/>
    <x-button type="submit" color="gray" size="lg" :full="true">Log In</x-button>
</x-form>
@endsection
<form wire:submit="submit" class="flex flex-col lg:w-1/4 w-full m-5 bg-white p-8 rounded-2xl drop-shadow-2xl shadow-white">
    <div class="flex justify-center w-full">
        <x-logo showDesc="false" />
    </div>
    <x-select name="Role" val_default_select="Pilih Role" :items="$roles" :form="true"/>
    <x-button type="submit" color="gray" size="lg" :full="true">Submit</x-button>
</form>
