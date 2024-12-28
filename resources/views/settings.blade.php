@extends('layouts.default')
@section('title', 'Settings')
@section('content') 

@php
    $user = Auth::user();
@endphp

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach


<form method="POST">
    @csrf
    <label>
        Name
        <input name="name" type="text" value="{{ $user->name }}" autofocus required>
    </label>

    <label>
        Email
        <input name="email" type="text" value="{{ $user->email }}" autofocus required>
    </label>

    <label>
        Password
        <input name="password" type="password" placeholder="min 8 chars">
        <small>Leave empty to remain unchanged</small>
    </label>
    <button type="submit">Save</button>
    <button type="reset">Reset</button>
</form>

@endsection