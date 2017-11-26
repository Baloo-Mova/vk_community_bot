@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('balanceheader_title')
            Управление балансом
        @endsection
        @section('balanceheader_badge')
            {{ $user->balance }} р.
        @endsection
    </div>

    <section class="content-header">
        <h1 class="page_title">
            Партнерская программа
        </h1>
    </section>

    <section class="text-information">

    </section>

    <div class="text-information">
        <div class="row">
            <div class="col s8">
                <p> Рекомендуйте сервис Knocker друзьям и подписчикам и получайте 30% от суммы их пополнения
                    пожизенно.</p>
            </div>
        </div>
        <div class="row">
            <form action="{{route('partnership.change')}}" method="POST">
                {{csrf_field()}}
                <div class="input-field col s4">
                    <span class="error">
                        @if($errors->has('my_promo'))
                            {{$errors->first('my_promo')}}
                        @endif
                    </span>
                    <input name="my_promo" id="my_promo" type="text" value="{{$user->my_promo}}"
                           class="validate name">
                    <label for="my_promo" class="promocode_change">Ваш промокод</label>

                </div>

                <div class="clearfix"></div>
                <div class="col s3">
                    <input type="submit" value="Изменить" class="btn btn-success">
                </div>
                <div class="clearfix"></div>
            </form>
        </div>

        <div class="row">
            <div class="col l7">
                <p>Вводя Ваш промокод при первом пополнении в разделе <a
                            href="{{route('balance.index')}}">Баланс</a>,
                    привлеченный пользователь дополнительно получает +300 рублей к любой сумме пополнения (от 1
                    рубля)</p>
            </div>
        </div>
        <div class="row">
            <div class="col l7">
                <p> Ваш партнерский баланс Вы можете увидеть в правом верхнем углу.
                    Запрос вывода осуществляется через техподдержку и производится в течении 72 часов.</p>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        .text-information {
            font-size: 18px;
            padding-left: 20px;
        }

        .text-information p {
            font-size: 20px;
            font-weight: 200;
            margin: 0!important;
        }

        section.text-information {
            margin-bottom: 20px;
        }

        .error {
            font-size: 14px;
            color: red;
        }

        .mb10 {
            margin-bottom: 10px;
        }
    </style>
@endsection