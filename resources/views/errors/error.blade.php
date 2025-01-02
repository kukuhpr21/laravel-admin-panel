@extends('layouts.guest')
@section('title', "Error $code")
@section('content')
{{ $code.' '.$message }}
@endsection
