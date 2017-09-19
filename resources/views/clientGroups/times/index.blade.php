@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Временные отрезки
        @endsection
        <div id="modal_add" class="modal">
            <div class="modal-content">
                <h4>Добавление</h4>
                <form action="{{ route('client.group.times.add') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="client_group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate">
                            <label for="name">Имя</label>
                        </div>

                        <div class="input-field col s12 datetime1">
                            <input name="from" id="from" class="when_send" type="text" data-field="datetime" readonly>
                            <label for="from" class="when_send">Дата сообщения с</label>
                            <div id="dtBox1"></div>
                        </div>

                        <div class="input-field col s12 datetime2">
                            <input name="to" id="to" class="when_send" type="text" data-field="datetime" readonly>
                            <label for="to" class="when_send">Дата сообщения по</label>
                            <div id="dtBox2"></div>
                        </div>
                    </div>

                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_edit" class="modal">
            <div class="modal-content">
                <h4>Редактирование списка</h4>
                <form action="{{ route('client.group.times.edit') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="client_group_id" value="{{ $group_id }}">
                    <input type="hidden" name="id" value="" class="time_edit_id">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate name">
                            <label for="name" class="name_send_edit">Имя</label>
                        </div>

                        <div class="input-field col s12 datetime3">
                            <input name="from" id="from" class="from" type="text" data-field="datetime" readonly>
                            <label for="from" class="from_send_edit">Дата сообщения с</label>
                            <div id="dtBox3"></div>
                        </div>

                        <div class="input-field col s12 datetime4">
                            <input name="to" id="to" class="to" type="text" data-field="datetime" readonly>
                            <label for="to" class="to_send_edit">Дата сообщения по</label>
                            <div id="dtBox4"></div>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Редактировать</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div id="lists" class="col s12">
                <div class="h10"></div>
                <a href="#modal_add"
                   class="waves-effect waves-light light-blue darken-4 btn">
                    Добавить
                </a>
                <div class="mt20">
                    <table class="highlight">
                        <thead>
                        <th class="col s2">Имя</th>
                        <th class="col s3">Время начала</th>
                        <th class="col s3">Время окончания</th>
                        <th class="col s4">Действия</th>
                        </thead>
                        <tbody>
                        @forelse($times as $time)
                            <tr>
                                <td class="col s2 table_td">
                                    {{ $time->name }}
                                </td>
                                <td class="col s3 table_td">
                                    {{ $time->from }}
                                </td>
                                <td class="col s3 table_td">
                                    {{ $time->to }}
                                </td>
                                <td class="col s4 table_td">
                                    <a class="waves-effect waves-light group_edit"
                                       data-id="{{ $time->id }}"
                                       data-name="{{$time->name }}"
                                       data-from="{{  \Carbon\Carbon::parse(substr($time->from,0,strlen($time->from) - 3))->format("d-m-Y H:i") }}"
                                       data-to="{{  \Carbon\Carbon::parse(substr($time->to,0,strlen($time->to) - 3))->format("d-m-Y H:i") }}"
                                       href="#modal_edit">
                                        <i class="material-icons left">edit</i>
                                    </a>
                                    <a href="{{ route('client.group.times.delete', ['id' => $time->id]) }}"
                                       class="waves-effect waves-light"
                                       onclick="return confirm('Вы действительно хотите удалить этот список?')">
                                        <i class="material-icons left">delete</i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="2">Пусто</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>

    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('.modal').modal();

            $("#dtBox1").DateTimePicker({
                "parentElement": ".datetime1",
                "language": "ru"
            });
            $("#dtBox2").DateTimePicker({
                "parentElement": ".datetime2",
                "language": "ru"
            });
            $("#dtBox3").DateTimePicker({
                "parentElement": ".datetime3",
                "language": "ru"
            });
            $("#dtBox4").DateTimePicker({
                "parentElement": ".datetime4",
                "language": "ru"
            });


            $(".group_edit").on("click", function () {
                var id = $(this).data("id"),
                    name = $(this).data("name"),
                    from = $(this).data("from"),
                    to = $(this).data('to');

                $('.time_edit_id').val(id);
                $(".name").val(name);
                $(".from").val(from);
                $(".to").val(to);
                $(".to_send_edit").addClass('active');
                $(".from_send_edit").addClass('active');
                $(".name_send_edit").addClass('active');
            });

        });
    </script>
@stop