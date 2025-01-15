@extends('layouts.app')
@section('title', 'Daftar User')
@section('content')
<x-page title="Daftar User">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('users-add') }}" :data="$dataTable"/>
</x-page>
@endsection
