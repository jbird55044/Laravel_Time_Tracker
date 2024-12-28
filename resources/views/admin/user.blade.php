@extends('layouts.default')
@section('title', 'Admin - User')
@section('content')
@php
  if (request()->has('id')) {
    $action = 'edit';
    $user = \App\Models\User::find(request()->get('id'));
  } else {
    $action = 'add';
  }
@endphp

@foreach ($errors->all() as $error)
  <p class="error">{{ $error }}</p>
@endforeach

<form method="POST" action="/admin/user/{{ $action }}">
  @csrf
  <input type="hidden" name="id" value="{{ isset($user) ? $user->id : old('id') }}">
  <label>
    Name
    <input name="name" type="text" value="{{ isset($user) ? $user->name : old('name') }}" autofocus required>
  </label>
  <label>
    Email
    <input name="email" type="email" value="{{ isset($user) ? $user->email : old('email') }}" required>
  </label>
  <label>
    Password
    <input name="password" type="password">
    <small>leave empty to remain unchanged</small>
  </label>
  <label>
    Admin
    <input type="checkbox" name="admin"
      @checked(isset($user) && $user->isAdmin())
      @disabled(isset($user) && Auth::user()->id == $user->id)
    >
  </label>

  <button type="submit">Save</button>
  <button type="button" onclick="location.href='/admin'">Cancel</button>
</form>
@endsection
