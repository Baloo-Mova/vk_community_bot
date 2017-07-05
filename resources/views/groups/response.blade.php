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
                            <a href="{{ route('groups.groupSettings', ['bot_id' => $group->id]) }}"
                               class="btn waves-effect waves-light light-blue darken-4 groups_back_button">Перейти к оплате</a>
                            <a href="{{ route('groups.index') }}"
                               class="btn waves-effect waves-light light-blue darken-4 groups_back_button">Назад</a>
                        </div>
                    </div>
                </div>
        @endif

            <div id="modal1" class="modal">
                <div class="modal-content">
                    <h4>Добавление сценария</h4>
                    <form action="{{ route('groups.add.response') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="input-field col s12">
                            <input name="key" id="key" type="text" class="validate">
                            <label for="key">Ключевое слово</label>
                        </div>
                        <div class="input-field col s12">
                            <input name="response" id="response" type="text" class="validate">
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
                            <select name="action_id">
                                <option value="" disabled selected>Выберите действие</option>
                                <option value="1">Добавить в группу</option>
                            </select>
                            <label>Действия</label>
                        </div>
                        <div class="h10"></div>
                        <div class="input-field col s12 mt10 group_select">
                            <select name="add_group_id">
                                <option value="" disabled selected>Выберите группу</option>
                                @forelse($client_groups as $clg)
                                    <option value="{{ $clg->id }}">{{ $clg->name }}</option>
                                @empty
                                    <option value="">У Вас нет Групп пользователей</option>
                                @endforelse
                            </select>
                            <label>Группы</label>
                        </div>
                        <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                    </form>
                </div>
            </div>

            <div id="modal2" class="modal">
                <div class="modal-content">
                    <h4>Редактирование сценария</h4>
                    <form action="{{ route('groups.edit.response') }}" class="scenario_edit_form" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="scenario_id" class="scenario_id">
                        <div class="input-field col s12">
                            <input name="key" id="key" class="scenario_key" type="text" class="validate">
                            <label for="key" class="scenario_key_label">Ключевое слово</label>
                        </div>
                        <div class="input-field col s12">
                            <input name="response" id="response" class="scenario_response" type="text" class="validate">
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
                            <select name="action_id">
                                <option value="" disabled selected>Выберите действие</option>
                                <option value="1">Добавить в группу</option>
                            </select>
                            <label>Действия</label>
                        </div>
                        <div class="h10"></div>
                        <div class="input-field col s12 group_select_edit">
                            <select name="add_group_id">
                                <option value="" disabled selected>Выберите группу</option>
                                @forelse($client_groups as $clg)
                                    <option value="{{ $clg->id }}">{{ $clg->name }}</option>
                                @empty
                                    <option value="">У Вас нет Групп пользователей</option>
                                @endforelse
                            </select>
                            <label>Группы</label>
                        </div>
                        <button class="waves-effect waves-green light-blue darken-4 btn">Сохранить</button>
                    </form>
                </div>
            </div>

        <div class="row">
            <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn" {{ !$group->payed ? 'disabled' : '' }}>Добавить сценарий</a>
            <div class="col s12">
                <table class="highlight">
                    <thead>
                        <th>Ключевое слово</th>
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
                                       data-edit-key="{{ $resp->key }}"
                                       data-edit-response="{{ $resp->response }}"
                                       href="#modal2">
                                        <i class="material-icons left">edit</i>
                                    </a>
                                    <a href="{{ route('groups.delete.response', ['response' => $resp->id]) }}"
                                       class="waves-effect waves-light"
                                       onclick="return confirm('Вы действительно хотите удалить этот сценарий?')">
                                        <i class="material-icons left">delete</i>
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
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.modal').modal();
            $('select').material_select();

            $('#modal_payed').modal('open',{
                    dismissible: false
                }
            );

            $(".resp_checkbox").on("change", function(){
                var resp_id = $(this).data('responseId'),
                    status = $(this).prop('checked');

                $.ajax({
                    method: "get",
                    url: "{{ url('/change-response-status') }}/" + resp_id + "/" + (status ? 1 : 0),
                    success: function (data) {}
                });
            });

            $(".scenario_edit").on("click", function () {
                var scenarion_id = $(this).data("editId"),
                    key          = $(this).data("editKey"),
                    response     = $(this).data("editResponse");

                $(".scenario_id").val(scenarion_id);
                $(".scenario_key_label").addClass('active');
                $(".scenario_key").val(key);
                $(".scenario_response_label").addClass('active');
                $(".scenario_response").val(response);
            });

            $(".is_action").on("change", function(){
                var state = $(this).prop("checked");

                if(state){
                    $(".action_select").css("display", "block");
                    $(".group_select").css("display", "none");
                }else{
                    $(".action_select").css("display", "none");
                    $(".group_select").css("display", "none");
                }
            });

            $(".action_select").on("change", function () {
                $(".group_select").css("display", "block");
            })
        });
    </script>

@stop
