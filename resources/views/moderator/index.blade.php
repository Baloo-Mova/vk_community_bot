@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Модератор
        @endsection
        @if(!$group->payed)
            <div id="modal_payed" class="modal">
                <div class="modal-content">
                    <h4>Внимание!</h4>
                    <div class="group_not_payed">
                        <p>В данный момент подписка на бота не оплачена. </p>
                        <a href="{{ route('groupSettings.index', ['bot_id' => $group->id]) }}"
                           class="btn waves-effect waves-light light-blue darken-4 groups_back_button">Перейти к
                            оплате</a>
                        <a href="{{ route('groups.index') }}"
                           class="btn waves-effect waves-light light-blue darken-4 groups_back_button">Назад</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <ul class="tabs">
                        <li class="tab col s2">
                            <a class="active" href="#history">История событий</a>
                        </li>
                        <li class="tab col s2">
                            <a href="#settings">Настройки</a>
                        </li>
                    </ul>
                </ul>
            </div>
            <div id="history" class="col s12">
                <div class="h10"></div>
                <div class="col s12">
                    <div class="col s12">
                        <table class="highlight">
                            <thead>
                            <th>Имя</th>
                            <th>Время</th>
                            <th>Событие</th>
                            </thead>
                            <tbody class="table_body">
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        {{ $log->name }}
                                    </td>
                                    <td>
                                        {{ $log->date }}
                                    </td>
                                    <td>
                                        {{ $log->description }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <p class="text-center">Нет данных для отображения!</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="col s12 text-center">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div id="settings" class="col s12">
                <div class="h10"></div>
                <div class="col s12">
                    @if($group->telegram == null)
                        <div class="row">
                            <div class="col s4">
                                <div class="add_telegram">
                                    <div id="telegram_info" class="modal" style="overflow: visible !important;">
                                        <div class="modal-content">
                                            <h4>Информация</h4>
                                            <p>
                                                Напишите нашему боту <b>@VkknockerBot</b> сообщение:
                                                <b>{{ $group->telegram_keyword }}</b>
                                            </p>
                                        </div>
                                    </div>
                                    <p>Внимание, привяжите Telegram</p>
                                    <a href="#telegram_info" class="waves-effect waves-light btn">Информация</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col s4">
                            <form action="{{ route('moderator.settings') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <div class="switch manager_telegram_status_row">
                                    <label>
                                        <input {{ $group->telegram == null ? "disabled" : "" }} {{ $group->send_to_telegram == 1 ? "checked" : "" }} name="send_to_telegram"
                                               type="checkbox">
                                        <span class="lever manager_telegram_status"></span>
                                        <span class=""> Получать на Telegram</span>
                                    </label>
                                </div>
                                <div class="switch manager_telegram_status_row">
                                    <label>
                                        <input {{ $group->show_in_history == 1 ? "checked" : "" }} name="show_in_history"
                                               type="checkbox">
                                        <span class="lever manager_telegram_status"></span>
                                        <span class=""> Отображать в истории</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <!-- сообщения-->
                                    <p>События:</p>

                                    @foreach($allEvents as $key => $value)
                                        <p>
                                            <input type="checkbox" name="event[{{$key}}]"
                                                   id="ch{{$key}}" {{ $value['check'] ? "checked" : ""  }}/>
                                            <label for="ch{{$key}}">{{$value['title']}}</label>

                                            @if(isset($value['scenario']))
                                                <button class="btn btn-primary">Сценарии</button>
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                                <div class="row input_row">
                                    <div class="input-field">
                                        <button type="submit" class="waves-effect waves-light btn">Сохранить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @stop

        @section('js')
            <script>
                $(document).ready(function () {
                    $(".moderator_select").material_select();
                    $('.modal').modal();

                    $('#modal_payed').modal('open', {
                            dismissible: false
                        }
                    );
                });
            </script>
@stop