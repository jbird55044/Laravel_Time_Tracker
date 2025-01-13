@extends('layouts.default')
@section('title', 'Entries')
@section('content')

@session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<table>
  <thead>
    <tr>
      <th>Job</th>
      <th>Date</th>
      <th>Hours</th>
      <th >Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach (Auth::user()->entries()->orderBy('entry_date', 'asc')->get() as $entry)
      <tr>
        <td>{{ $entry->job->name }}</td>
        <td>{{ $entry->entry_date }}</td>
        <td>{{ $entry->hours }}</td>
        <td>{{ $entry->description }}</td>
        <td style="text-align: center">
          @if ($entry->approvals->count() > 0)
            Approved
          @else
              <a href="/entry?id={{ $entry->id }}">Edit</a>
              <a >-</a>
              <a href="/entry/delete?id={{ $entry->id }}"
                onClick="return confirm('Are you sure you want to delete entry {{ $entry->id }} ?')">Delete</a>
          @endif

          {!! $entry->approvals->count() > 0 ? '&checkmark;' : '' !!}
        </td>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <form method="POST" action="/entry/add">
      @csrf
      <tr>
        <td>
          <select name="job_id" required>
            <option value="">- Choose Job -</option>
            @foreach (\App\Models\JobCode::all() as $job)
              <option value="{{ $job->id}}">{{ $job->name }}</option>
            @endforeach
          </select>
        </td>
        <td>
           <input type="date" name="entry_date" value="{{ date('Y-m-d') }}" required>
        </td>
        <td>
          <input type="number" name="hours" max="24" min="0" step="0.1" required>
        </td>
        <td>
          <input type="text" name="description" maxlength="255">
        </td>
        <td>
          <button type="submit">Save</button>
          <button type="reset">Reset</button>
        </td>
      </tr>
     
    </form>
  </tfoot>
</table>

@endsection
