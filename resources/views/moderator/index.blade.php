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
                           class="btn waves-effect waves-light light-blue darken-4 groups_back_button">Перейти к оплате</a>
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
                    <table class="highlight">
                        <thead>
                            <th></th>
                            <th>Имя</th>
                            <th>Время</th>
                            <th>Событие</th>
                        </thead>
                        <tbody>
                            <tr>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            {{ $log->event_id }}
                                        </td>
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
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="settings" class="col s12">
                <div class="h10"></div>
                <div class="col s12">
                    <div class="row">
                        <div class="col s4">
                            <div class="add_telegram">
                                <form action="">
                                    <p>Привяжите Telegramm</p>
                                    <div class="row input_row">
                                        <div class="input-field col s12">
                                            <input id="telegram" type="text" class="validate">
                                            <label for="telegram">Telegram</label>
                                        </div>
                                    </div>
                                    <div class="row input_row">
                                        <div class="input-field col s12">
                                            <button type="submit" class="waves-effect waves-light btn">Добавить</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4">
                            <form action="">
                                <div class="row">
                                    <!-- сообщения-->
                                    <p>Сообщения:</p>
                                    <p>
                                        <input type="checkbox" id="ch1" />
                                        <label for="ch1">Входящее сообщение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch2" />
                                        <label for="ch2">Исходящее сообщение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch3" />
                                        <label for="ch3">Разрешение на получение</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch4" />
                                        <label for="ch4">Запрет на получение</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- фотографии-->
                                    <p>Фотографии:</p>
                                    <p>
                                        <input type="checkbox" id="ch5" />
                                        <label for="ch5">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch6" />
                                        <label for="ch6">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch7" />
                                        <label for="ch7">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch8" />
                                        <label for="ch8">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch9" />
                                        <label for="ch9">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Аудиозаписи-->
                                    <p>Аудиозаписи:</p>
                                    <p>
                                        <input type="checkbox" id="ch10" />
                                        <label for="ch10">Добавление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Видеозаписи-->
                                    <p>Видеозаписи:</p>
                                    <p>
                                        <input type="checkbox" id="ch11" />
                                        <label for="ch11">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch12" />
                                        <label for="ch12">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch13" />
                                        <label for="ch13">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch14" />
                                        <label for="ch14">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch15" />
                                        <label for="ch15">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Записи на стене -->
                                    <p>Записи на стене:</p>
                                    <p>
                                        <input type="checkbox" id="ch16" />
                                        <label for="ch16">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch17" />
                                        <label for="ch17">Репост</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Комментарии на стене -->
                                    <p>Комментарии на стене:</p>
                                    <p>
                                        <input type="checkbox" id="ch18" />
                                        <label for="ch18">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch19" />
                                        <label for="ch19">Редактирование</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch20" />
                                        <label for="ch20">Удаление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch21" />
                                        <label for="ch21">Восстановление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Обсуждения -->
                                    <p>Обсуждения:</p>
                                    <p>
                                        <input type="checkbox" id="ch22" />
                                        <label for="ch22">Добавление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch23" />
                                        <label for="ch23">Редактирование</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch24" />
                                        <label for="ch24">Удаление</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch25" />
                                        <label for="ch25">Восстановление</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Товары -->
                                    <p>Товары:</p>
                                    <p>
                                        <input type="checkbox" id="ch26" />
                                        <label for="ch26">Новый комментарий</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch27" />
                                        <label for="ch27">Редактирование комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch28" />
                                        <label for="ch28">Удаление комментария</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch29" />
                                        <label for="ch29">Восстановление удалённого комментария</label>
                                    </p>
                                </div>
                                <div class="row">
                                    <!-- Прочее -->
                                    <p>Прочее:</p>
                                    <p>
                                        <input type="checkbox" id="ch30" />
                                        <label for="ch30">Вступление в сообщество</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch31" />
                                        <label for="ch31">Выход из сообщества</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch32" />
                                        <label for="ch32">Изменение настроек</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch33" />
                                        <label for="ch33">Голос в публичном опросе</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch34" />
                                        <label for="ch34">Изменение главной фотографии</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" id="ch35" />
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
                $(document).ready(function(){
                    $(".client_group_id").material_select();
                    $(".client_edit_group_id").material_select();
                    $('.modal').modal();

                    $('#modal_payed').modal('open',{
                            dismissible: false
                        }
                    );
                });
                $(".funnel_edit").on("click", function () {
                    var funnel_id = $(this).data("editId"),
                        name          = $(this).data("editName");
                        clgr          = $(this).data("editClgr");

                    $(".edit_funnel_id").val(funnel_id);
                    $(".edit_funnel_name_label").addClass('active');
                    $(".edit_funnel_name").val(name);

                    $(".client_edit_group_id").material_select('destroy');
                    $(".client_edit_group_id").val(clgr);
                    $(".client_edit_group_id").material_select();
                });
            </script>
@stop