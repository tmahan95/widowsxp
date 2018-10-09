@extends('layouts.app')

@section('content')
@if (session('message'))
	<div class="alert alert-info">{{ session('message') }}</div>
@endif
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel-heading">Users</div>
				<a href="/register">Create New User</a>
				
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>
									<a href="{{ route('users.edit', $user->id) }}" class="btn btn-default">Edit</a>
									<form action="{{ route('users.destroy', $user->id) }}" method="POST"
										style="display: inline"
										onsubmit="return confirm('Are you sure?');">
										<input type="hidden" name="_method" value="DELETE">
										{{ csrf_field() }}
										<button class="btn btn-danger">Delete</button>
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3"> No Entries found.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					{{ $users->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
