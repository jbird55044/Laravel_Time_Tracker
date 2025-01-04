@auth
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Admin</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach (\App\Models\User::orderBy('id')->get() as $user)
      <tr>
        <td>{{ $user->name }} -- id:{{ $user->id }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->info->admin == 1 ? 'Yes' : 'No' }}</td>
        <td style="text-align:center">
          <a href="/admin/approvers?user={{ $user->id}}">Approver Setup</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endauth
