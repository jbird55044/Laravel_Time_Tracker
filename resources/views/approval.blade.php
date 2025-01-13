@extends('layouts.default')
@section('title', 'Approve Time')
@section('content')

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

@php
    $authUser = auth()->user(); // Get the authenticated user
@endphp

@auth
<div class="selector-box">
    <!-- Table 1: Users Who Can Approve You -->
    <h2>Users Who Can Approve You</h2>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($authUser->approvers as $user) <!-- Users who can approve the authenticated user -->
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>

<div class="selector-box">
    <!-- Table 2: Users You Can Approve -->
    <h2>Users You Can Approve</h2>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Admin</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($authUser->approvals as $user) <!-- Users the authenticated user can approve -->
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->info->admin == 1 ? 'Yes' : 'No' }}</td>
            <td style="text-align:center">
              <a href="/admin/entries?user={{ $user->id }}">Approve</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>
@endauth

@endsection
