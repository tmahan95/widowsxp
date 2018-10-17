@extends('layouts.app')

@section('content')
@if (session('message'))
	<div class="alert alert-info">{{ session('message') }}</div>
@endif

@if(isset($message))
	{{ $message }}
@endif

	<form action="{{ route('progSearch') }}" method="POST" role="search">
		<div class="container">
			{{ csrf_field() }}
			<div class="input-group">
				<input type="text" class="form-control" name="q" placeholder="Search logs"> <span class="input-group-btn">
				<button type="submit" class="btn btn-primary" text="Submit">Search</button>
			</div>

		</div>
	</form>
@if(isset($programs))
<a href="{{ route('program.create') }}" class="btn btn-default">Add New Program</a>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel-heading">Programs</div>
				
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Computer Name</th>
								<th>Program Name</th>
								<th>Version</th>
							</tr>
						</thead>
						<tbody>
							@forelse($programs as $program)
							<tr>
								<td><a href="{{ route('refinedProgSearch', ['q'=>$program->compname]) }}">{{ $program->compname }}</a></td>
								<td><a href="{{ route('refinedProgSearch', ['q'=>$program->progname]) }}">{{ $program->progname }}</a>
								<td><a href="{{ route('refinedProgSearch', ['q'=>$program->version]) }}">{{ $program->version}}</a></td>
							</tr>
							@empty
							<tr>
								<td colspan="3"> No Entries found.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endif
@endsection

