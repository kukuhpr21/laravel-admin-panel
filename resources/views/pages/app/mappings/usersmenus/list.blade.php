@extends('layouts.app')
@section('title', 'Daftar Mapping User Menu')
@section('content')
<x-page title="Daftar Mapping User Menu">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-menus-add') }}" :data="$dataTable"/>
</x-page>
@endsection
