@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
			<ul>
				{{ Auth::user()->is_admin }}
				<li><a href="{{ route('users.index') }}">Users</a></li>
				<li><a href="/logs">Logs</a></li>
				<li><a href="{{ route('import') }}">Import</a></li>
			</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
