@extends('layouts.default')
@section('title', 'Login')
@section('content')

  <form method="POST">
    @csrf
    <label>
      Email
      <input class="form-email" name="email" type="text" autofocus required>
    </label>
    <label>
      Password
      <input name="password" type="password" required>
    </label>
    <button type="submit">Login</button>
    @if (session('error'))
      <span class="error">{{ session('error') }}</span>
    @endif
  </form>
@endsection
