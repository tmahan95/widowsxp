@extends('layouts.app')

@section('content')

@if (session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
@endif

@if(isset($message))
        {{ $message }}
@endif

        <form action="{{ route('monSearch') }}" method="POST" role="search">
                <div class="container">
                        {{ csrf_field() }}
                        <div class="input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search serials"> <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" text="Submit">Search</button>
                        </div>
                        <a href="{{ route('refinedLogSearch', ['q'=>session('query')] ) }}" class="btn btn-secondary" Text="Back to Logs">Back to Logs</a>

                </div>
        </form>
        <div class="container">
                @if(isset($details))
                        <p> The Search results for your query <b> {{ $query }} </b> are: </p>
                        <h2> Serials</h2>
                        <table class="table table-striped">
                                <thead>
                                        <tr>
                                                <th>Computer Name</th>
                                                <th>Serial Number</th>
                                        <tr>
                                </thead>
                                <tbody>
                                        @foreach($details as $logs)
                                                <tr>
                                                        <td> <a href="{{ route('monSearch', ['q'=>$logs->compname]) }}">{{ $logs->compname }}</a></td>
                                                        <td> <a href="{{ route('monSearch',['q'=>$logs->monSerial]) }}"> {{ $logs->monSerial }}</a></td>
						</tr>
                                        @endforeach
                                </tbody>
                        </table>
                @endif
        </div>
@endsection

