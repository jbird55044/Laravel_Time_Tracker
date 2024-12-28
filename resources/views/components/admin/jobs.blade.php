{{-- @session('success')
    <p class="success">{{ $value }} </p>
@endsession

@foreach ($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach --}}


@auth
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Billing Code</th>
      <th>Updated At</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach (\App\Models\JobCode::all() as $job)
      <tr>
        <td><a href="/admin/job?id={{$job->id}}">{{ $job->name }}</a></td>
        <td>{{ $job->billing_code }}</td>
        <td>{{ $job->updated_at }}</td>
        <td>
          <a href="/admin/job/delete?id={{ $job->id }}"
          onClick="return confirm('Are you sure you want to delete entry {{ $job->id }} ?')">Delete {{$job->id}}</a>
        </td>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3">
        <a href="/admin/job">Add New Job</a>
      </td>
    </tr>
  </tfoot>
</table>
@endauth
