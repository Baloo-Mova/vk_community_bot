@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('balanceheader_title')
            Управление балансом
        @endsection
        @section('balanceheader_badge')
            {{ $user->balance }} р.
        @endsection

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="active" href="#balance">
                            Баланс
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
                    <div class="input-field col s12 m6 l4 xl3">
                        <input type="text" name="sum" id="sum" required>
                        <label for="sum">Сумма пополнения (руб)</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn  light-blue darken-4 waves-effect wavev-light">Пополнить</button>
                    </div>
                </form>
            </div>
            <div id="history" class="col s12 tab_content_custom">
                <table class="highlight centered">
                    <thead>
                        <th>Тип</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                            <tr>
                                <td>{{ $pay->description == 1 ? "Пополнение баланса" : "Оплата подписки" }}</td>
                                <td>{{ $pay->payment_sum }} руб</td>
                                <td>{{ $pay->status == 1 ? "Успешно" : "Неуспешно" }}</td>
                                <td>{{ $pay->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">Нет платежей</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection