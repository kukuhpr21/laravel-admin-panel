@extends('layouts.app')
@section('title', 'Daftar Menu')
@section('content')
<x-page title="Daftar Menu">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('menus-add') }}" :data="$dataTable"/>
</x-page>
@endsection
