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
  if (request()->has('id')) {
    $action = 'edit';
    $user = \App\Models\User::find(request()->get('id'));
  } else {
    $action = 'add';
  }
@endphp

@auth
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
    @foreach (\App\Models\User::all() as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->info->admin == 1 ? 'Yes' : 'No' }}</td>
        <td style="text-align:center">
          <a href="/admin/entries?user={{ $user->id}}">Approval</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endauth


@endsection
