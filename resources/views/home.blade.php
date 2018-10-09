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
				<li><a href="/admin/users">Users</a></li>
				<li><a href="/admin/authors">Authors</a></li>
				<li><a href="/logs">Logs</a></li>
			</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
