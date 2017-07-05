@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Рассылка
        @endsection

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
                    <form action="{{ route('groups.add.massDelivery') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" value="{{ $group_id }}">
                        <input type="hidden" name="rules" value="test_rules">
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
                            <input name="when_send" id="when_send" class="when_send" type="text" maxlength="19" value="{{ \Carbon\Carbon::now() }}">
                            <label for="when_send" class="when_send">Дата рассылки</label>
                        </div>


                        <button class="waves-effect waves-green light-blue darken-4 btn">Сохранить</button>
                    </form>
                </div>
            </div>
            <div id="list" class="col s12 tab_content_custom">
                <table class="highlight">
                    <thead>
                    <th>Сообщение</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                    </thead>
                    <tbody>
                    @forelse($deliveries as $delivery)
                        <tr {{ $delivery->sended ? "teal lighten-4" : "" }}>
                            <td>{{ $delivery->message }}</td>
                            <td>{{ $delivery->created_at }}</td>
                            <td>
                                <a href="{{ route('groups.delete.massDelivery', ['response' => $delivery->id]) }}"
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

@stop

@section('js')
    <script>
        $(document).ready(function () {
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