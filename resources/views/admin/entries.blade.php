@extends('layouts.default')
@section('title', 'Admin - Entries')
@section('content')
@php
    $user_id = request()->get('user');
    $user = \App\Models\User::find($user_id);
@endphp

<h2>Time Entries for:  {{ $user->name }}</h2>

<table>
  <p>Entry for User ID:  {{$user_id}} </p>
  <thead>
    <tr>
      <th>Job</th>
      <th>Date</th>
      <th>Hours</th>
      <th>Description</th>
      <th>Approved</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($user->entries as $entry)
      <tr>
        <td>{{ $entry->job->name }}</td>
        <td>{{ $entry->entry_date }}</td>
        <td>{{ $entry->hours }}</td>
        <td>{{ $entry->description }}</td>
        <td style="text-align: center">
          {!! $entry->approvals->count() > 0 ? '&checkmark;' : '' !!}
        </td>
        <td>
          <a href="/admin/entries?user={{ $user_id }}&approve={{ $entry->id }}">Approve</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<button type="button" onclick="location.href='/admin'">Back to Admin</button>
@endsection
