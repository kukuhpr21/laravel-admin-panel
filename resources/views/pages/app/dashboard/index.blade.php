@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<x-page title="Dashboard">
    <div class="flex flex-col gap-4">
        @include('pages.app.dashboard.section1')
        @include('pages.app.dashboard.section2')
    </div>
</x-page>
@endsection
