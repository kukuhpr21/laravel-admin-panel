@extends('layouts.app')
@section('title', 'Daftar Mapping Menu Permission')
@section('content')
<x-page title="Daftar Mapping Menu Permission">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('menus-permissions-add') }}" :data="$dataTable"/>
</x-page>
@endsection
