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
            <th>User ID</th>
            <th>User Name</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>admin@welcome.com</td>
            <td>Administrator</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>jbird@JamesDBird.com</td>
            <td>James Bird</td>
            <td>Approver of all</td>
        </tr>
        <tr>
            <td>user1@welcome.com</td>
            <td>Normal User 1</td>
            <td>Aprover for Some</td>
        </tr>
        <tr>
            <td>user2@welcome.com</td>
            <td>Normal User 2</td>
            <td>General User</td>
        </tr>
        <tr>
            <td>user3@welcome.com</td>
            <td>Normal User 3</td>
            <td>General User</td>
        </tr>
    </tbody>
</table>
@endsection
