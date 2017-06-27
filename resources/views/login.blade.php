@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login With VK</div>

                    <div class="panel-body">
                         <a href="{{route('vk_login')}}" class="btn btn-vk"> Войти через VK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
