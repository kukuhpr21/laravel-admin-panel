@extends('layouts.guest')
@section('title', 'Choose Role')
@section('content')
<x-form routeName="choose-role" class="lg:w-1/4 mx-3 sm:mx-0">
    <div class="flex justify-center w-full">
        <x-logo :showDesc="false" />
    </div>
    <x-select name="Role" :data="$roles"/>
    <x-button type="submit" color="gray" size="lg" :full="true">Submit</x-button>
</x-form>
@endsection
