@extends('layouts.default')
@section('title', 'Admin')
@section('content') 

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<h2>Job Codes</h2>
    @include('/components/admin/jobs')

<h2>Users</h2>
    @include('/components/admin/users')

@endsection