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

  <p>Below is a list of default users and roles.  Note: All users have the same default password</p>
  <p>Default Password is: ___________________</p>

  <table>
    <thead>
      <tr>
        <th>Table ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Admin</th>
      </tr>
    </thead>
    <tbody>
      @foreach (\App\Models\User::orderBy('id')->get() as $user)
        <tr>
          <td>{{ $user->id}}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->info->admin == 1 ? 'Yes' : 'No' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
