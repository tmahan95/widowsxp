@extends('layouts.app')

@section('content')

@if (session('message'))
	<div class="alert alert-info">{{ session('message') }}</div>
@endif

@if(isset($message))
	{{ $message }}
@endif

	<form action="{{ route('logs.searchLogs') }}" method="POST" role="search">
		<div class="container">
			{{ csrf_field() }}
			<div class="input-group">
				<input type="text" class="form-control" name="q" placeholder="Search logs"> <span class="input-group-btn">
				<button type="submit" class="btn btn-primary" text="Submit">Search</button>
			</div>

		</div>
	</form>
	<div class="container">
		@if(isset($details))
			<p> The Search results for your query <b> {{ $query }} </b> are: </p>
			<h2> Logs</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Username</th>
						<th>Computer Name</th>
						<th>IP Address</th>
						<th>OS Version</th>
						<th>OS Build</th>
						<th>BIOS Version</th>
						<th>BIOS Date</th>
						<th>Model</th>
						<th>Serial</th>
					<tr>
				</thead>
				<tbody>
					@foreach($details as $logs)
						<tr>
							<td> {{ $logs->date }}</td>
							<td> <a href="{{ route('refinedLogSearch', ['q'=>$logs->uname]) }}">{{ $logs->uname }}</a></td>
							<td> <a href="{{ route('logs.index', ['q'=>$logs->compname]) }}">{{ $logs->compname }}</a></td>
							<td> <a href="{{ route('logs.index', ['q'=>$logs->ipaddress]) }}">{{ $logs->ipaddress }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->os_version]) }}">{{ $logs->os_version }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->os_build]) }}"> {{ $logs->os_build }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->bios_version]) }}"> {{ $logs->bios_version }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->bios_date]) }}"> {{ $logs->bios_date }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->model]) }}"> {{ $logs->model }}</a></td>
							<td> <a href="{{ route('logs.index',['q'=>$logs->serial]) }}"> {{ $logs->serial }}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
@endsection
