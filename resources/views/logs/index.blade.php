@extends('layouts.app')
@section('scripts')
<script>
$(document).ready(function () {
	$("p").click();
	$("p").click(function() {
		$("p").toggle();
	});

//jquery search feature FIRST COLUMN ONLY
/*$("#myInput").keyup(function(){
	var filter, tr, td, i;
	filter = $("#myInput:text").val().toUpperCase();
	tr = $("#logTable").find("tr");


	for (i = 0 ; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if(td) {
			if(td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else{
				tr[i].style.display = "none";
			}
		} 
	}
});*/
/*$("#myInput").keyup(function(){
	var filter, tr, td, i, j;
	filter = $("#myInput:text").val().toUpperCase();
	tr = $("#logTable").find("tr");


	for (i = 0 ; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td");
		for (j = 0; j < td.length; j++) {
			if(td[j]) {
				if(td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
					break;
				} else{
					tr[i].style.display = "none";
				}
			}	
		}
	}
});
 */
//Search ALL columns
$("#myInput").on("keyup", function() {
	var value = $(this).val();
	$("table tr").each(function(index) {
	    if (index !== 0) {
	        $row = $(this);
	
	        $row.find('td').each (function() {
	            var id = $(this).text();
	            if (id.indexOf(value) !== 0) {
	                $row.hide();
	            }
	            else {
	                $row.show();
	                return false;
	            }
	        });
	
	    }
	});
});

});
 </script>
@endsection

@section('content')
@if (session('message'))
	<div class="alert alert-info">{{ session('message') }}</div>
	@endif

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
						<th>Name</th>
						<th>Email</th>
					<tr>
				</thead>
				<tbody>
					@foreach($details as $user)
						<tr>
							<td> {{ $user->name }}</td>
							<td> {{ $user->email }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel-heading">Logs</div>
				
				<div class="panel-body">
					<table class="table table-bordered" id="logTable">
						<tr><input type="text" id="myInput" placeholder="Search Logs"></input></tr>
						<thead>
							<tr>
								<th>Date</th>
								<th>User Name</th>
								<th>Computer Name</th>
								<th>IP Address</th>
								<th>OS Version</th>
								<th>OS Build</th>
								<th>BIOS Version</th>
								<th>BIOS Date</th>
								<th>Model</th>
								<th>Serial</th>
							</tr>
						</thead>
						<tbody>
							@forelse($logs as $log)
							<tr>
								<td>{{ $log->date }}</td>
								<td>{{ $log->uname }}</td>
								<td>{{ $log->compname }}</td>
								<td>{{ $log->ipaddress }}</td>
								<td>{{ $log->os_version }}</td>
								<td>{{ $log->os_build }}</td>
								<td>{{ $log->bios_version }}</td>
								<td>{{ $log->bios_date }}</td>
								<td>{{ $log->model }}</td>
								<td>{{ $log->serial }}</td>
								<td>
									<a href="{{ route('logs.edit', $log->id) }}" class="btn btn-default">Edit</a>
									<form action="{{ route('logs.destroy', $log->id) }}" method="POST"
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
					{{ $logs->links() }}
				</div>
			</div>
		</div>
	</div>

<p>Click Me</p>
	    
@endsection
