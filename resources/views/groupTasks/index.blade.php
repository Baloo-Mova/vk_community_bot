@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Сценарий ответов
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
        <div id="modal1" class="modal" style="overflow: visible !important; padding: 20px 0px;">
            <div class="modal-content modal__content" style="overflow-y: auto;">
                <h4>Добавление сценария</h4>
                <form action="{{ route('groupTasks.add') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                    <div class="input-field col s12">
                        <input name="scenario_name" id="scenario_name" type="text" class="validate">
                        <label for="scenario_name">Имя сценария</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="key" id="key" type="text" class="validate">
                        <label for="key">Ключевые слова (для указания нескольких фраз используйте разделитель
                            ";")</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="response" name="response" class="materialize-textarea"></textarea>
                        <label for="response">Ответ</label>
                    </div>
                    <div class="switch">
                        <label>
                            <input type="checkbox" class="is_action">
                            <span class="lever"></span>
                            <span class="bot_status">
                            действие</span>
                        </label>
                    </div>
                    <div class="h10"></div>
                    <div class="input-field col s12 mt10 action_select">
                        <select name="action_id" class="action_select_select">
                            <option value="" disabled selected>Выберите действие</option>
                            <option value="1">Добавить в группу</option>
                            <option value="2">Удалить из группы</option>
                            <option value="3">Удалить из базы</option>
                        </select>
                        <label>Действия</label>
                    </div>
                    <div class="h10"></div>
                    <div class="input-field col s12 mt10 group_select">
                        <select name="add_group_id" class="group_select_select">
                            <option value="" disabled selected>Выберите группу</option>
                            @forelse($client_groups as $clg)
                                <option value="{{ $clg->id }}">{{ $clg->name }}</option>
                            @empty
                                <option value="" disabled>У Вас нет Групп пользователей</option>
                            @endforelse
                        </select>
                        <label>Группы</label>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div class="modal" id="actionsInvokedModal" style="overflow: visible !important; padding: 20px 0px;">
            <div class="modal-content modal__content" style="overflow-y: auto">
                <h4>Частота срабатывания</h4>
                <table class="bordered">
                    <thead>
                    <th>Ключ</th>
                    <th>Кол-во срабатываний</th>
                    </thead>
                    <tbody id="actionsInvoked">

                    </tbody>
                </table>
            </div>
        </div>

        <div id="modal2" class="modal" style="overflow: visible !important; padding: 20px 0px;">
            <div class="modal-content modal__content" style="overflow-y: auto;">
                <h4>Редактирование сценария</h4>
                <form action="{{ route('groupTasks.edit') }}" class="scenario_edit_form" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="scenario_id" class="scenario_id">
                    <div class="input-field col s12">
                        <input name="scenario_name" class="scenario_name" id="scenario_name" type="text"
                               class="validate">
                        <label for="scenario_name" class="scenario_name_label">Имя сценария</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="key" id="key" class="scenario_key" type="text" class="validate">
                        <label for="key" class="scenario_key_label">Ключевые слова (для указания нескольких фраз
                            используйте разделитель ";")</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="response" name="response"
                                  class="materialize-textarea scenario_response"></textarea>
                        <label for="response" class="scenario_response_label">Ответ</label>
                    </div>
                    <div class="switch">
                        <label>
                            <input type="checkbox" class="is_action_edit">
                            <span class="lever"></span>
                            <span class="bot_status">
                            действие</span>
                        </label>
                    </div>
                    <div class="h10"></div>
                    <div class="input-field col s12 action_select_edit">
                        <select name="action_id" class="action_select_edit_select">
                            <option value="" disabled class="action_select_edit_0">Выберите действие</option>
                            <option value="1" class="action_select_edit_1">Добавить в группу</option>
                            <option value="2" class="action_select_edit_2">Удалить из группы</option>
                            <option value="3" class="action_select_edit_3">Удалить из базы</option>
                        </select>
                        <label>Действия</label>
                    </div>
                    <div class="h10"></div>
                    <div class="input-field col s12 group_select_edit">
                        <select name="add_group_id" class="group_select_edit_select">
                            <option value="" disabled class="group_select_edit_-1">Выберите группу</option>
                            @forelse($client_groups as $clg)
                                <option value="{{ $clg->id }}"
                                        class="group_select_edit_{{ $clg->id }}">{{ $clg->name }}</option>
                            @empty
                                <option value="" disabled>У Вас нет Групп пользователей</option>
                            @endforelse
                        </select>
                        <label>Группы</label>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Сохранить</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    @include('layouts.partials.groups-maintabs')
                </ul>
            </div>
            <div id="task" class="col s12">
                <div class="h10"></div>
                <a href="#modal1"
                   class="waves-effect waves-light light-blue darken-4 btn" {{ !$group->payed ? 'disabled' : '' }}>Добавить
                    сценарий</a>
                <div class="">
                    <table class="highlight">
                        <thead>
                        <th>Имя сценария</th>
                        <th>Ключевые слова</th>
                        <th>Ответ</th>
                        <th>Статус</th>
                        <th>Действия</th>
                        </thead>
                        <tbody>
                        @if(!$group->payed)
                            <tr>
                                <td class="text-center" colspan="4">Нет записей</td>
                            </tr>
                        @else

                            @forelse($responses as $resp)
                                <tr>
                                    <td>{{ $resp->scenario_name }}</td>
                                    <td>{{ $resp->key }}</td>
                                    <td>{{ $resp->response }}</td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                                <input {{ $resp->state == 1 ? 'checked' : '' }}
                                                       class="resp_checkbox"
                                                       data-response-id="{{$resp->id}}"
                                                       type="checkbox">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="waves-effect waves-light scenario_edit"
                                           data-edit-id="{{ $resp->id }}"
                                           data-edit-scenario-name="{{ $resp->scenario_name }}"
                                           data-edit-key="{{ $resp->key }}"
                                           data-edit-response="{{ $resp->response }}"
                                           data-edit-action-id="{{ ($resp->action_id) ? $resp->action_id : -1 }}"
                                           data-edit-add-group-id="{{ ($resp->add_group_id) ? $resp->add_group_id : -1 }}"
                                           href="#modal2">
                                            <i class="material-icons left">edit</i>
                                        </a>
                                        <a href="{{ route('groupTasks.delete', ['response' => $resp->id]) }}"
                                           class="waves-effect waves-light"
                                           onclick="return confirm('Вы действительно хотите удалить этот сценарий?')">
                                            <i class="material-icons left">delete</i>
                                        </a>
                                        <a href="{{route('group.task.times', ['id'=>$resp->id])}}"
                                           class="waves-effect waves-light link_group"
                                           title="Ссылка на подписку">
                                            <i class="material-icons left">timer</i>
                                        </a>
                                        <a class="waves-effect waves-light scenario_edit"
                                           data-id="{{ $resp->id }}"
                                           id="showInfo">
                                            <i class="material-icons left">info_outline</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">Нет записей</td>
                                </tr>
                            @endforelse
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media screen and (max-width: 400px) {
            .modal__content {
                height: 370px;
            }
        }

        @media screen and (min-width: 400px) {
            .modal__content {
                height: 450px;
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.modal').modal();
            $('.action_select_select').material_select();
            $('.group_select_select').material_select();
            $('.action_select_edit_select').material_select();
            $('.group_select_edit_select').material_select();

            $('#modal_payed').modal('open', {
                    dismissible: false
                }
            );

            $('#showInfo').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    method: "GET",
                    data: {id: id},
                    url: "{{ route('actionsInvoked') }}",
                    success: function (data) {
                        var toShow = '';

                        for (var i = 0; i < data.length; i++) {
                            toShow += '<tr><td>' + data[i].key + '</td><td>' + data[i].count + '</td></tr>';
                        }
                        $('#actionsInvoked').html(toShow);
                        $('#actionsInvokedModal').modal('open');
                    },
                    error: function (data) {
                        toastr.error('Возникла ошибка, обратитесь к администрации');
                    }
                })
            });

            $(".resp_checkbox").on("change", function () {
                var resp_id = $(this).data('responseId'),
                    status = $(this).prop('checked');

                $.ajax({
                    method: "get",
                    url: "{{ url('/change-response-status') }}/" + resp_id + "/" + (status ? 1 : 0),
                    success: function (data) {
                    }
                });
            });

            $(".scenario_edit").on("click", function () {
                var scenarion_id = $(this).data("editId"),
                    scenarion_name = $(this).data("editScenarioName"),
                    key = $(this).data("editKey"),
                    response = $(this).data("editResponse"),
                    action_id = $(this).data("editActionId"),
                    group_id = $(this).data("editAddGroupId");

                $(".scenario_id").val(scenarion_id);
                $(".scenario_key_label").addClass('active');
                $(".scenario_key").val(key);
                $(".scenario_response_label").addClass('active');
                $(".scenario_response").val(response);
                $(".scenario_name_label").addClass('active');
                $(".scenario_name").val(scenarion_name);

                if (action_id != -1) {
                    $(".is_action_edit").prop("checked", true);
                    $(".action_select_edit").css("display", "block");
                    $(".group_select_edit").css("display", "block");
                    $('.action_select_edit_select').material_select('destroy');
                    $('.group_select_edit_select').material_select('destroy');
                    $(".action_select_edit_select").val(action_id);
                    $('.group_select_edit_select').val(group_id);
                    $('.action_select_edit_select').material_select();
                    $('.group_select_edit_select').material_select();

                } else {
                    $(".is_action_edit").prop("checked", false);
                    $(".action_select_edit").css("display", "none");
                    $(".group_select_edit").css("display", "none");
                    $('.action_select_edit_select').material_select('destroy');
                    $('.group_select_edit_select').material_select('destroy');
                    $(".action_select_edit_select").val(0);
                    $('.group_select_edit_select').val(-1);
                    $('.action_select_edit_select').material_select();
                    $('.group_select_edit_select').material_select();
                }
            });

            $(".is_action").on("change", function () {
                var state = $(this).prop("checked");

                if (state) {
                    $(".action_select").css("display", "block");
                    $(".group_select").css("display", "none");
                } else {
                    $('.action_select_select').material_select('destroy');
                    $('.group_select_select').material_select('destroy');
                    $(".action_select_select").val(0);
                    $('.group_select_select').val(-1);
                    $('.action_select_select').material_select();
                    $('.group_select_select').material_select();
                    $(".action_select").css("display", "none");
                    $(".group_select").css("display", "none");
                }
            });

            $(".action_select").on("change", function () {
                $(".group_select").css("display", "block");
            });

            $(".is_action_edit").on("change", function () {
                var state = $(this).prop("checked");

                if (state) {
                    $(".action_select_edit").css("display", "block");
                    $(".group_select_edit").css("display", "none");
                } else {
                    $('.action_select_edit_select').material_select('destroy');
                    $('.group_select_edit_select').material_select('destroy');
                    $(".action_select_edit_select").val(0);
                    $('.group_select_edit_select').val(-1);
                    $('.action_select_edit_select').material_select();
                    $('.group_select_edit_select').material_select();
                    $(".action_select_edit").css("display", "none");
                    $(".group_select_edit").css("display", "none");
                }
            });

            $(".action_select_edit").on("change", function () {
                $(".group_select_edit").css("display", "block");
            });


        });
    </script>

@stop