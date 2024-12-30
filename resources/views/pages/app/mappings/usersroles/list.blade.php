@extends('layouts.app')
@section('title', 'Daftar Mapping User Role')
@section('content')
<x-page title="Daftar Mapping User Role">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-roles-add') }}" :data="$dataTable"/>
</x-page>
@endsection
