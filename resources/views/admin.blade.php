@extends('layouts.default')
@section('title', 'Admin')
@section('content') 

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<h2>Job Codes Management</h2>
    @include('/components/admin/jobs')

<h2>User and Approver Management</h2>
    @include('/components/admin/users')

<h2>Approver Management</h2>
    @include('/components/admin/approvers_list')

@endsection