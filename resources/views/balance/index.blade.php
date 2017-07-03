@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Управление балансом
        @endsection
        <span class="contentheader_badge badge blue">{{ $user->balance }}</span>

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="active" href="#balance">
                            Управление балансом
                        </a>
                    </li>
                    <li class="tab col s3">
                        <a href="#history">История</a>
                    </li>
                </ul>
            </div>
            <div id="balance" class="col s12">
                <form action="{{ route('balance.replenishment') }}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="sum" required>
                    <button>Пополнить</button>
                </form>
            </div>
            <div id="history" class="col s12">
                Test 2
            </div>
        </div>

    </div>
@endsection