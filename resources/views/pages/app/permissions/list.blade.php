@extends('layouts.app')
@section('title', 'Daftar Permission')
@section('content')
<x-page title="Daftar Permission">
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('permissions-add') }}" :data="$dataTable"/>
</x-page>
@endsection
