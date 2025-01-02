@extends('layouts.guest')
@section('title', "Error $code")
@section('content')
<div class="flex flex-col gap-4 items-center">
    <span class="text-2xl sm:text-6xl text-slate-600 font-semibold">{{ $code }}</span>
    <img src="{{ asset('assets/images/outer-space.svg') }}" alt="illustration" class="rounded-full bg-slate-300 drop-shadow-2xl h-[200px] w-[200px] sm:h-[400px] sm:w-[400px]">
    <span class="text-xl sm:text-4xl text-slate-600 font-semibold">{{ $message }}</span>
    <a href="{{ url()->previous() }}" class="bg-slate-500 rounded-lg sm:rounded-xl py-2 px-4 sm:py-3 sm:px-6 text-slate-100 text-base sm:text-lg font-bold transition duration-150 ease-out hover:ease-in hover:scale-110 hover:bg-slate-600">Back Home</a>
</div>
@endsection
