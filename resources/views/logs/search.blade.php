@extends('layouts.app')

@section('content')


	<form action="/search" method="POST" role="search">
		<div class="container">
			{{ csrf_field() }}
			<div class="input-group">
				<input type="text" class="form-control" name="q" placeholder="Search users"> <span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>

		</div>
	</form>
	<div class="container">
		@if(isset($details))
			<p> The Search results for your query <b> {{ $query }} </b> are: </p>
			<h2> Sample User Details</h2>
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
							<td> {{ $logs->uname }}</td>
							<td> {{ $logs->compname }}</td>
							<td> {{ $logs->ipaddress }}</td>
							<td> {{ $logs->os_version }}</td>
							<td> {{ $logs->os_build }}</td>
							<td> {{ $logs->bios_version }}</td>
							<td> {{ $logs->bios_date }}</td>
							<td> {{ $logs->model }}</td>
							<td> {{ $logs->serial }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>

@endsection
