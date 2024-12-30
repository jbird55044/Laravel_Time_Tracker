@extends('layouts.default')
@section('title', 'Entries')
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
    @foreach ($authUser->approvals as $user) <!-- Only users the authenticated user can approve -->
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->info->admin == 1 ? 'Yes' : 'No' }}</td>
        <td style="text-align:center">
          <a href="/admin/entries?user={{ $user->id }}">Approval</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endauth

@endsection