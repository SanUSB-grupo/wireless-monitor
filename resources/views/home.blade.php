@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>
        </div>
        <div class="jumbotron">
            <h2 class="text-center">
                You are now connected!
                <br><br>
                Click to create your first monitor
                <hr>
                <a href="{{ url('/monitor') }}" class="btn btn-primary">
                    Monitor
                </a>
            </h2>
        </div>
    </div>
</div>
@endsection
