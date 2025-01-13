@extends('layouts.default')
@section('title', 'Admin Approval - Time Entries')
@section('content')
@php
    $user_id = request()->get('user');
    $user = \App\Models\User::find($user_id);
@endphp

<div class="header-container">
  <h2>Time Entries for:  {{ $user->name }}</h2>
  <small class="inline">User ID: {{$user->id}}</small>
</div>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

@foreach ($errors->all() as $error)
  <p class="error">{{ $error }}</p>
@endforeach

<table>
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
    
    @foreach ($user->entries->sortBy('entry_date') as $entry)
      <tr>
        <td>{{ $entry->job->name }}</td>
        <td>{{ $entry->entry_date }}</td>
        <td>{{ $entry->hours }}</td>
        <td>{{ $entry->description }}</td>
        <td style="text-align: center">
          {!! $entry->approvals->count() > 0 ? '&checkmark;' : '' !!}  {{-- the !! is to allow the &checkmark to work --}}
        </td>
        {{-- <td>
          <a href="/admin/entries?user={{ $user_id }}&approve={{ $entry->id }}">
            {{ $entry->approvals->count() > 0 ? 'Decline' : 'Approve'}}</a>
        </td> --}}
        <td>
          <form action="{{ route('entries.toggleApprove', $entry->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
              {{ $entry->approvals->count() > 0 ? 'Decline' : 'Approve' }}
            </button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<button type="button" onclick="location.href='/admin'">Back to Admin</button>
@endsection
