@extends('layouts.default')
@section('title', 'Admin - Job_Code')
@section('content')
@php
  if (request()->has('id')) {
    $action = 'edit';
    $job = \App\Models\JobCode::find(request()->get('id'));
  } else {
    $action = 'add';
  }
@endphp

@foreach ($errors->all() as $error)
  <p class="error">{{ $error }}</p>
@endforeach


<form method="POST" action="/admin/job/{{ $action }}">
    @csrf
    {{-- <p>Job ID: {{$job->id}} </p> --}}
    <input type="hidden" name="id" value="{{ isset($job) ? $job->id : old('id') }}">
    <label>
      Name
      <input name="name" type="text" value="{{ isset($job) ? $job->name : old('name') }}" autofocus required>
    </label>
    <label>
      Billing Code
      <input name="billing_code" type="text" value="{{ isset($job) ? $job->billing_code : old('billing_code') }}" required>
    </label>

    <button type="submit">Save</button>
    <button type="button" onclick="location.href='/admin'">Cancel</button>
  </form>
@endsection
