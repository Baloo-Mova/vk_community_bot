@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
@section('contentheader_title')
    Рассылка
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
            @include('layouts.partials.groups-maintabs')
        </ul>
    </div>
    <div id="delivery" class="col s12">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="active" href="#create">Создание</a>
                    </li>
                    <li class="tab col s3">
                        <a href="#list">Список</a>
                    </li>
                </ul>
            </div>
            <div id="create" class="col s12 tab_content_custom">
                <div class="col s12 m6 l4 xl4">
                    <form action="{{ route('massDelivery.add') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" value="{{ $group_id }}">
                        <input type="hidden" name="rules" value="test_rules">
                        <div class="input-field col s12">
                            <input id="media" name="media" class="validate" type="text">
                            <label for="media">Вложения</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="message" name="message" class="materialize-textarea"></textarea>
                            <label for="message">Текст</label>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Состоит</label>
                                <select class="browser-default in_select" name="in[]" multiple="multiple">
                                    <option value="" disabled>Выберите группу</option>
                                    @forelse($groups as $gr)
                                        <option value="{{ $gr->id }}"
                                                class="in_select_item in_select_item_{{ $gr->id }}">{{ $gr->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <label>Не состоит</label>
                                <select class="browser-default not_in_select" name="not_in[]" multiple="multiple">
                                    <option value="" disabled>Выберите группу</option>
                                    @forelse($groups as $gr)
                                        <option value="{{ $gr->id }}"
                                                class="not_in_select_item not_in_select_item_{{ $gr->id }}">{{ $gr->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="switch">
                            <label>
                                <input type="checkbox" class="delivery_time">
                                <span class="lever"></span>
                                Отсроченная рассылка
                            </label>
                        </div>
                        <div class="h10"></div>
                        <div class="input-field col s12 when_send_wrap">
                            <input name="when_send" id="when_send" class="when_send" type="text" data-field="datetime" readonly>
                            <label for="when_send" class="when_send">Дата рассылки</label>
                            <div id="dtBox"></div>
                        </div>
                        <button class="waves-effect waves-green light-blue darken-4 btn" {{ !$group->payed ? 'disabled' : '' }}>Сохранить</button>
                    </form>
                </div>
                <div class="col m6 l8 hide-on-med-and-down">
                    <img src="{{asset('/img/howto.png')}}" class="responsive-img">
                </div>
            </div>
            <div id="list" class="col s12 tab_content_custom">
                <table class="highlight">
                    <thead>
                    <th>Сообщение</th>
                    <th>Дата отправки</th>
                    <th>Действия</th>
                    </thead>
                    <tbody>
                    @forelse($deliveries as $delivery)
                        <tr class="{{ $delivery->sended ? "teal lighten-4" : "" }}">
                            <td>{{ $delivery->message }}</td>
                            <td>{{ $delivery->when_send }}</td>
                            <td>
                                <a href="{{ route('massDelivery.delete', ['response' => $delivery->id]) }}"
                                   class="waves-effect waves-light"
                                   onclick="return confirm('Вы действительно хотите удалить эту рассылку?')">
                                    <i class="material-icons left">delete</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">Нет рассылок</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

    @section('js')
        <script>
            $(document).ready(function () {

                $("#dtBox").DateTimePicker({
                    "language"       : "ru"
                });

                $('#modal_payed').modal('open',{
                        dismissible: false
                    }
                );

                $(".in_select").select2();
                $(".not_in_select").select2();

                $(".in_select").on("change", function () {
                    var v = $(this).val();
                    if (v === null) {
                        togleItemsStatus(".not_in_select", ".not_in_select_item", false);
                        return false;
                    }
                    togleItemsStatus(".not_in_select", ".not_in_select_item", false);

                    $(".not_in_select").select2("destroy");

                    if (v.length > 1) {
                        v.forEach(function (item, i, arr) {
                            $(".not_in_select_item_" + item).attr("disabled", true);
                        });
                    } else {
                        $(".not_in_select_item_" + v).attr("disabled", true);
                    }
                    $(".not_in_select").select2();
                });

                $(".not_in_select").on("change", function () {
                    var v = $(this).val();
                    if (v === null) {
                        togleItemsStatus(".in_select", ".in_select_item", false);
                        return false;
                    }
                    togleItemsStatus(".in_select", ".in_select_item", false);

                    $(".in_select").select2("destroy");

                    if (v.length > 1) {
                        v.forEach(function (item, i, arr) {
                            $(".in_select_item_" + item).attr("disabled", true);
                        });
                    } else {
                        $(".in_select_item_" + v).attr("disabled", true);
                    }
                    $(".in_select").select2();
                });

                $(".delivery_time").on("change", function () {
                    var state = $(this).prop("checked");
                    if (state) {
                        $(".when_send_wrap").css("display", "block");
                    } else {
                        $(".when_send_wrap").css("display", "none");
                        $(".when_send").val("");
                    }
                });

                function togleItemsStatus(name, name2, state) {
                    $(name).select2("destroy");
                    $(name2).attr("disabled", state);
                    $(name).select2();
                }
            });


        </script>
@stop