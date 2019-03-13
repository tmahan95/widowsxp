@extends('layouts.app')

@section('content')


        <form action="{{ route('monSearch') }}" method="POST" role="search">
                <div class="container">
                        {{ csrf_field() }}
                        <div class="input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search monitors"> <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Search</button>
                        </div>

                </div>
        </form>
        <div class="container">
                @if(isset($details))
                        <p> The Search results for your query <b> {{ $query }} </b> are: </p>
                        <h2> Monitors</h2>
                        <table class="table table-striped">
                                <thead>
                                        <tr>
                                                <th>Computer Name</th>
                                                <th>Serial</th>
                                        <tr>
                                </thead>
                                <tbody>
                                        @foreach($details as $logs)
                                                <tr>
                                                        <td> {{ $logs->compname }}</td>
                                                        <td> {{ $logs->monSerial }}</td>
                                                </tr>
                                        @endforeach
                                </tbody>
                        </table>
                @endif
        </div>

@endsection
