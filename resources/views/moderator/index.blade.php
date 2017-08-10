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
                                    <p>Сообщения:</p>
                                    <p>
                                        <input type="checkbox" name="event[message_new]"
                                               id="ch1" {{ $events_number > 0 && isset($events["message_new"]) ? "checked" : ""  }}/>
                                        <label for="ch1">Входящее сообщение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[message_reply]"
                                               id="ch2" {{ $events_number > 0 && isset($events["message_reply"]) ? "checked" : ""  }}/>
                                        <label for="ch2">Исходящее сообщение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[message_allow]"
                                               id="ch3" {{ $events_number > 0 && isset($events["message_allow"]) ? "checked" : ""  }}/>
                                        <label for="ch3">Разрешение на получение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[message_deny]"
                                               id="ch4" {{ $events_number > 0 && isset($events["message_deny"]) ? "checked" : ""  }}/>
                                        <label for="ch4">Запрет на получение</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- фотографии-->
                                    <p>Фотографии:</p>
                                    <p>
                                        <input type="checkbox" name="event[photo_new]"
                                               id="ch5" {{ $events_number > 0 && isset($events["photo_new"]) ? "checked" : ""  }}/>
                                        <label for="ch5">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[photo_comment_new]"
                                               id="ch6" {{ $events_number > 0 && isset($events["photo_comment_new"]) ? "checked" : ""  }}/>
                                        <label for="ch6">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[photo_comment_edit]"
                                               id="ch7" {{ $events_number > 0 && isset($events["photo_comment_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch7">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[photo_comment_delete]"
                                               id="ch8" {{ $events_number > 0 && isset($events["photo_comment_delete"]) ? "checked" : ""  }}/>
                                        <label for="ch8">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[photo_comment_restore]"
                                               id="ch9" {{ $events_number > 0 && isset($events["photo_comment_restore"]) ? "checked" : ""  }}/>
                                        <label for="ch9">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Аудиозаписи-->
                                    <p>Аудиозаписи:</p>
                                    <p>
                                        <input type="checkbox" name="event[audio_new]"
                                               id="ch10" {{ $events_number > 0 && isset($events["audio_new"]) ? "checked" : ""  }}/>
                                        <label for="ch10">Добавление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Видеозаписи-->
                                    <p>Видеозаписи:</p>
                                    <p>
                                        <input type="checkbox" name="event[video_new]"
                                               id="ch11" {{ $events_number > 0 && isset($events["video_new"]) ? "checked" : ""  }}/>
                                        <label for="ch11">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[video_comment_new]"
                                               id="ch12" {{ $events_number > 0 && isset($events["video_comment_new"]) ? "checked" : ""  }}/>
                                        <label for="ch12">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[video_comment_edit]"
                                               id="ch13" {{ $events_number > 0 && isset($events["video_comment_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch13">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[video_comment_delete]"
                                               id="ch14" {{ $events_number > 0 && isset($events["video_comment_delete"]) ? "checked" : ""  }}/>
                                        <label for="ch14">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[video_comment_restore]"
                                               id="ch15" {{ $events_number > 0 && isset($events["video_comment_restore"]) ? "checked" : ""  }}/>
                                        <label for="ch15">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Записи на стене -->
                                    <p>Записи на стене:</p>
                                    <p>
                                        <input type="checkbox" name="event[wall_post_new]"
                                               id="ch16" {{ $events_number > 0 && isset($events["wall_post_new"]) ? "checked" : ""  }}/>
                                        <label for="ch16">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[wall_repost]"
                                               id="ch17" {{ $events_number > 0 && isset($events["wall_repost"]) ? "checked" : ""  }}/>
                                        <label for="ch17">Репост</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Комментарии на стене -->
                                    <p>Комментарии на стене:</p>
                                    <p>
                                        <input type="checkbox" name="event[wall_reply_new]"
                                               id="ch18" {{ $events_number > 0 && isset($events["wall_reply_new"]) ? "checked" : ""  }}/>
                                        <label for="ch18">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[wall_reply_edit]"
                                               id="ch19" {{ $events_number > 0 && isset($events["wall_reply_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch19">Редактирование</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[wall_reply_delete]"
                                               id="ch20" {{ $events_number > 0 && isset($events["wall_reply_delete"]) ? "checked" : ""  }}/>
                                        <label for="ch20">Удаление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[wall_reply_restore]"
                                               id="ch21" {{ $events_number > 0 && isset($events["wall_reply_restore"]) ? "checked" : ""  }}/>
                                        <label for="ch21">Восстановление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Обсуждения -->
                                    <p>Обсуждения:</p>
                                    <p>
                                        <input type="checkbox" name="event[board_post_new]"
                                               id="ch22" {{ $events_number > 0 && isset($events["board_post_new"]) ? "checked" : ""  }}/>
                                        <label for="ch22">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[board_post_edit]"
                                               id="ch23" {{ $events_number > 0 && isset($events["board_post_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch23">Редактирование</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[board_post_delete]"
                                               id="ch24" {{ $events_number > 0 && isset($events["board_post_delete"]) ? "checked" : ""  }}/>
                                        <label for="ch24">Удаление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[board_post_restore]"
                                               id="ch25" {{ $events_number > 0 && isset($events["board_post_restore"]) ? "checked" : ""  }}/>
                                        <label for="ch25">Восстановление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Товары -->
                                    <p>Товары:</p>
                                    <p>
                                        <input type="checkbox" name="event[market_comment_new]"
                                               id="ch26" {{ $events_number > 0 && isset($events["market_comment_new"]) ? "checked" : ""  }}/>
                                        <label for="ch26">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[market_comment_edit]"
                                               id="ch27" {{ $events_number > 0 && isset($events["market_comment_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch27">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[market_comment_delete]"
                                               id="ch28" {{ $events_number > 0 && isset($events["market_comment_delete"]) ? "checked" : ""  }}/>
                                        <label for="ch28">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[market_comment_restore]"
                                               id="ch29" {{ $events_number > 0 && isset($events["market_comment_restore"]) ? "checked" : ""  }}/>
                                        <label for="ch29">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Прочее -->
                                    <p>Прочее:</p>
                                    <p>
                                        <input type="checkbox" name="event[group_join]"
                                               id="ch30" {{ $events_number > 0 && isset($events["group_join"]) ? "checked" : ""  }}/>
                                        <label for="ch30">Вступление в сообщество</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[group_leave]"
                                               id="ch31" {{ $events_number > 0 && isset($events["group_leave"]) ? "checked" : ""  }}/>
                                        <label for="ch31">Выход из сообщества</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[group_change_settings]"
                                               id="ch32" {{ $events_number > 0 && isset($events["group_change_settings"]) ? "checked" : ""  }}/>
                                        <label for="ch32">Изменение настроек</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[poll_vote_new]"
                                               id="ch33" {{ $events_number > 0 && isset($events["poll_vote_new"]) ? "checked" : ""  }}/>
                                        <label for="ch33">Голос в публичном опросе</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[group_change_photo]"
                                               id="ch34" {{ $events_number > 0 && isset($events["group_change_photo"]) ? "checked" : ""  }}/>
                                        <label for="ch34">Изменение главной фотографии</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" name="event[group_officers_edit]"
                                               id="ch35" {{ $events_number > 0 && isset($events["group_officers_edit"]) ? "checked" : ""  }}/>
                                        <label for="ch35">Изменение руководства</label>
                                    </p>
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

                    $(".moderator_select .initialized").on("change", function () {
                        var scenario_id = $(this).val(),
                            group_id = $(this).data("groupId");
                        window.location = "{{ url('/moderator') }}/" + group_id + "/" + scenario_id ;
                    });


                });
            </script>
@stop