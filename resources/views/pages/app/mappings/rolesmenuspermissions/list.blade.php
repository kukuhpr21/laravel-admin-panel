@extends('layouts.app')
@section('title', 'Daftar Mapping Role Menu Permission')
@section('content')
<x-page title="Daftar Mapping Role Menu Permission">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('roles-menus-permissions-add') }}" :data="$dataTable"/>
</x-page>
@endsection
