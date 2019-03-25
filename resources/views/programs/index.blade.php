@extends('layouts.app')

@section('content')
@if (session('message'))
	<div class="alert alert-info">{{ session('message') }}</div>
@endif

@if(isset($message))
	{{ $message }}
@endif

	<form action="{{ route('logSearch') }}" method="POST" role="search">
		<div class="container">
			{{ csrf_field() }}
			<div class="input-group">
				<input type="text" class="form-control" name="q" placeholder="Search logs"> <span class="input-group-btn">
				<button type="submit" class="btn btn-primary" text="Submit">Search</button>
			</div>
			<a href="{{ route('refinedLogSearch', ['q'=>session('query')] ) }}" class="btn btn-secondary" Text="Back to Logs">Back to Logs</a>

		</div>
	</form>
	<br/>
@if(isset($programs))
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
								<td><a href="{{ route('progSearch', ['q'=>$program->compname]) }}">{{ $program->compname }}</a></td>
								<td><a href="{{ route('progSearch', ['q'=>$program->progname]) }}">{{ $program->progname }}</a>
								<td><a href="{{ route('progSearch', ['q'=>$program->version]) }}">{{ $program->version}}</a></td>
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

