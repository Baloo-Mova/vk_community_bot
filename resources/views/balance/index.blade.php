@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('balanceheader_title')
            Управление балансом
        @endsection
        @section('balanceheader_badge')
            {{ $user->balance }}
        @endsection

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
            <div id="balance" class="col s12 tab_content_custom">
                <form action="{{ route('balance.replenishment') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-field col s12">
                        <input type="text" name="sum" id="sum" required>
                        <label for="sum">Сума пополнения (руб)</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn  light-blue darken-4 waves-effect wavev-light">Пополнить</button>
                    </div>
                </form>
            </div>
            <div id="history" class="col s12 tab_content_custom">
                Test 2
            </div>
        </div>

    </div>
@endsection