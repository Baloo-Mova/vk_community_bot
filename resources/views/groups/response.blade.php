@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Сценарий ответов
        @endsection

            <!-- Modal Structure -->
            <div id="modal1" class="modal">
                <div class="modal-content">
                    <h4>Добавление сценария</h4>
                    <form action="{{ route('groups.add.response') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" value="{{ $group_id }}">
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="key" id="key" type="text" class="validate">
                                <label for="key">Ключевое слово</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="response" id="response" type="text" class="validate">
                                <label for="response">Ответ</label>
                            </div>
                        </div>
                        <button class="waves-effect waves-green btn">Добавить</button>
                    </form>
                </div>
            </div>

            <div id="modal2" class="modal">
                <div class="modal-content">
                    <h4>Редактирование сценария</h4>
                    <form action="{{ route('groups.add.response') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" class="scenario_id">
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="key" id="key" class="scenario_key" type="text" class="validate">
                                <label for="key">Ключевое слово</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="response" id="response" class="scenario_response" type="text" class="validate">
                                <label for="response">Ответ</label>
                            </div>
                        </div>
                        <button class="waves-effect waves-green btn">Сохранить</button>
                    </form>
                </div>
            </div>

        <div class="row">
            <a href="#modal1" class="waves-effect waves-light btn">Добавить сценарий</a>
            <div class="col s12">
                <table class="highlight">
                    <thead>
                        <th>Ключевое слово</th>
                        <th>Ответ</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </thead>
                    <tbody>
                    @forelse($responses as $resp)
                        <tr>
                            <td>{{ $resp->key }}</td>
                            <td>{{ $resp->response }}</td>
                            <td>
                                <div class="switch">
                                    <label>
                                        Off
                                        <input {{ $resp->state == 1 ? 'checked' : '' }}
                                               class="resp_checkbox"
                                               data-response-id="{{$resp->id}}"
                                               type="checkbox">
                                        <span class="lever"></span>
                                        On
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
                    key          = $(this).data("editId"),
                    response     = $(this).data("editId");
                alert(scenarion_id);
            });
        });
    </script>

@stop
