@extends('layouts.app')
@section('title', 'Daftar Mapping Role Menu')
@section('content')
<x-page title="Daftar Mapping Role Menu">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('roles-menus-add') }}" :data="$dataTable"/>
</x-page>
@endsection
