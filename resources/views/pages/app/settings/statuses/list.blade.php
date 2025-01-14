@extends('layouts.app')
@section('title', 'Daftar Status')
@section('content')
<x-page title="Daftar Status">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('statuses-add') }}" :data="$dataTable"/>
</x-page>
@endsection
