@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Hello! {{ $user->FIO }}</div>

            <div class="panel-body">
                <img src="{{$user->avatar}}" class="img-responsive" style="max-height: 200px;max-width: 200px;">
                You are logged in!
            </div>
        </div>
    </div>
@endsection
