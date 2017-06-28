@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Управление группами
        @endsection

            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3">
                            <a class="active" href="#test1">Группы с доступом</a>
                        </li>
                        <li class="tab col s3">
                            <a href="#test2">Разрешить доступ</a>
                        </li>
                    </ul>
                </div>
                <div id="test1" class="col s3">
                    <div class="card small">
                        <div class="card-content">
                            <img src="https://pp.userapi.com/c629424/v629424021/38cda/QVZ0yXquNDc.jpg" class="circle responsive-img">
                            <span class="card-title activator grey-text text-darken-4">Название<i class="material-icons right">more_vert</i></span>
                            <p>28.06.2017</p>
                        </div>
                        <div class="groups_options_card_wrap card-reveal">
                            <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                            <span class="card-title grey-text text-darken-4 small groups_options_card_title">Настройки</span>
                            <ul class="groups_options_card_ul">
                                <li class="groups_options_card waves-effect wavev-dark"><a href="" class="grey-text text-darken-2 ">Бот</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div id="test2" class="col s12">
                    Test 2
                </div>
            </div>

    </div>
@endsection
