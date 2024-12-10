@extends('layouts.app')
@section('title', 'Daftar Role')
@section('content')
<x-page title="Daftar Role">
    <x-table :showButtonAdd="true" routeButtonAdd="roles-add" :data="$dataTable"/>
</x-page>
@endsection
