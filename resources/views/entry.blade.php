@extends('layouts.default')
@section('title', 'Entries')
@section('content')
@php
    $entry_id = request()->get('id');
    $entry = \App\Models\Entry::find($entry_id);
@endphp

@foreach ($errors->all() as $error)
  <p class="error">{{ $error }}</p>
@endforeach

<h2>Edit Entry # {{ $entry_id }} </h2>

<form method="POST" action="/entry/edit">
  @csrf
  <input type="hidden" name="id" value="{{ $entry_id }}">
  <label>
    Job Code
    <select name="job_id" required>
      <option value="">- Choose Job -</option>
      @foreach (\App\Models\JobCode::all() as $job)
        <option value="{{ $job->id }}" @selected($job == $entry->job)>
          {{ $job->name }}
        </option>
      @endforeach
    </select>
  </label>

  <label>
    Date
    <input type="date" name="entry_date" value="{{ $entry->entry_date->format('Y-m-d') }}" required>
  </label>

  <label>
    Hours
    <input type="number" name="hours" max="24" min="0" step="0.1" value="{{ $entry->hours }}" required>
  </label>

  <label>
    Description
    <textarea name="description" cols="40" rows="7" maxlength="255">{{ $entry->description }}</textarea>
  </label>

  <button type="submit">Save</button>
  <button type="reset">Reset</button>
  <button type="button" onclick="location.href='/entries'">Cancel</button>

</form>

@endsection
