@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel-heading">Add New Program</div>


				<div class="panel-body"> 
						@if($errors->count() > 0)
							<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						@endif
				<form action ="{{ route('program.store') }}" method="post">

				<div class="panel-body">
					<form action="{{ route('program.store') }}" method="post">
						{{ csrf_field() }}
						Computer Name:
						<br />
						<input type="text" name="compname" value="{{ old('compname') }}" />
						<br />
						<br />
						Program Name:
						<br />
						<input type="text" name="progname" value="{{ old('progname') }}" />
						<br /><br />
						Version:
						<br />
						<input type="text" name="version" value="{{ old('version') }}" />
						<br /><br />
						<input type="submit" value="Submit" class="btn btn-default" />
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
