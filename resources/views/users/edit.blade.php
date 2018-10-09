@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if (session('message'))
					<div class="alert alert-info">{{ session('message') }}</div>
				@endif
				<div class="panel-heading">Edit Author</div>
				<div class="panel-body">
						@if($errors->count() > 0)
							<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						@endif
					<form action="{{ route('users.update', $user) }}" method="post">
						<input type="hidden" name="_method" value="PUT">
						{{ csrf_field() }}
						First name:
						<br />
						<input type="text" name="name" value="{{ $user->name }}" />
						<br />
						<br />
						Email:
						<br />
						<input type="text" name="email" value="{{ $user->email }}" />
						<br /><br/>
						Password:
						<br />
						<input type="password" name="password" />
						<br /><br/>
						Confirm Password:
						<br />
						<input type="password" name="password_confirmation"/>
						<br /><br/>
						<input type="submit" value="Submit" class="btn btn-default" />
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
