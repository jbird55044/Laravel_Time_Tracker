@extends('layouts.default')
@section('title', 'Admin')
@section('content') 

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<div class="selector-box">
    <h2 class="selector-box">Job Codes Management</h2>
    @include('/components/admin/jobs')
</div>

<div class="selector-box">
    <h2 class="selector-box">User and Approver Management</h2>
    @include('/components/admin/users')
</div>

{{-- <div class="selector-box">
    <h2 class="selector-box">Approver Management</h2>
    @include('/components/admin/approvers_list')
</div> --}}

@endsection