@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Время
        @endsection

        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Добавление времени</h4>
                <form action="{{ route('funnels.add.time') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="funnel_id" value="{{ $funnel->id }}">
                    <div class="row">
                        <div class="input-field col s4">
                            <input name="days" id="days" type="text" class="validate" value="0">
                            <label for="days">Через дней</label>
                        </div>
                        <div class="input-field col s4">
                            <input name="hours" id="hours" type="text" class="validate" value="0">
                            <label for="hours">Через часов</label>
                        </div>
                        <div class="input-field col s4">
                            <input name="minutes" id="minutes" type="text" class="validate" value="0">
                            <label for="minutes">Через минут</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="text" name="text" class="materialize-textarea"></textarea>
                            <label for="text">Текст</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn" >Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_edit" class="modal">
            <div class="modal-content">
                <h4>Редактирование времени</h4>
                <form action="{{ route('funnels.edit.time') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="time_id" class="edit_time_id">
                    <div class="row">
                        <div class="input-field col s4">
                            <input name="days" id="days" type="text" class="validate edit_days" value="0">
                            <label for="days edit_days_label">Через дней</label>
                        </div>
                        <div class="input-field col s4">
                            <input name="hours" id="hours" type="text" class="validate edit_hours" value="0">
                            <label for="hours edit_hours_label">Через часов</label>
                        </div>
                        <div class="input-field col s4">
                            <input name="minutes" id="minutes" type="text" class="validate edit_minutes" value="0">
                            <label for="minutes edit_minutes_label">Через минут</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="text" name="text" class="materialize-textarea edit_text"></textarea>
                            <label for="text" class="edit_text_label">Текст</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn" >Сохранить</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div id="lists" class="col s12">
                <div class="h10"></div>
                <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn">Добавить время</a>
                <div class="mt20">
                    <table class="highlight">
                        <thead>
                            <th class="col s3">Время</th>
                            <th class="col s6">Текст</th>
                            <th class="col s3">Действия</th>
                        </thead>
                        <tbody>
                            @forelse($times as $time)
                                <tr>
                                    <td class="col s3 funnels_tds">
                                        {{ sprintf('%02d дня %02d часов %02d минут', $time->time/86400, ($time->time % 86400)/3600, (($time->time % 86400)%3600) / 60) }}
                                    </td>
                                    <td class="col s6 funnels_tds">
                                        <!--<div class="text_wrap">-->
                                            {{ $time->text }}
                                        <!--</div>-->
                                    </td>
                                    <td class="col s3">
                                        <a class="waves-effect waves-light time_edit funnel_action"
                                           data-edit-id="{{ $time->id }}"
                                           data-edit-days="{{ intval($time->time/86400) }}"
                                           data-edit-hours="{{ intval(($time->time % 86400)/3600) }}"
                                           data-edit-minutes="{{ intval((($time->time % 86400)%3600) / 60) }}"
                                           data-edit-text="{{ $time->text }}"
                                           href="#modal_edit">
                                            <i class="material-icons left">edit</i>
                                        </a>
                                        <a href="{{ route('funnels.delete.time', ['time_id' => $time->id]) }}"
                                           class="waves-effect waves-light funnel_action"
                                           onclick="return confirm('Вы действительно хотите удалить это время?')">
                                            <i class="material-icons left">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="3">Нет результатов</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @stop

        @section('js')
            <script>
                $(document).ready(function(){
                    $('.modal').modal();


                    $(".time_edit").on("click", function () {
                        var time_id = $(this).data("editId"),
                            days          = $(this).data("editDays"),
                            hours          = $(this).data("editHours"),
                            minutes          = $(this).data("editMinutes"),
                            text          = $(this).data("editText");

                        $(".edit_time_id").val(time_id);
                        $(".edit_days_label").addClass('active');
                        $(".edit_days").val(days);
                        $(".edit_hours_label").addClass('active');
                        $(".edit_hours").val(hours);
                        $(".edit_minutes_label").addClass('active');
                        $(".edit_minutes").val(minutes);
                        $(".edit_text_label").addClass('active');
                        $(".edit_text").val(text);
                        $('.edit_text').trigger('autoresize');
                    });
                });
            </script>
@stop