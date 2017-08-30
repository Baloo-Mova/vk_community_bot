@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Списки пользователей
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

        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Добавление списка</h4>
                <form action="{{ route('clientGroups.add.group') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate">
                            <label for="name">Имя</label>
                        </div>
                        <div class="switch">
                            <label>
                                <input type="checkbox" name="need_show" class="need_show_in_app">
                                <span class="lever"></span>
                                Показывать в списке
                            </label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_edit" class="modal">
            <div class="modal-content">
                <h4>Редактирование списка</h4>
                <form action="{{ route('clientGroups.edit.group') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" class="edit_group_id">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate edit_group_name">
                            <label for="name" class="edit_group_name_label">Имя</label>
                        </div>
                        <div class="switch">
                            <label>
                                <input type="checkbox" name="need_show" class="need_show_in_app_edit">
                                <span class="lever"></span>
                                Показывать в списке
                            </label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Редактировать</button>
                </form>
            </div>
        </div>

        <div id="modal_link" class="modal">
            <div class="modal-content">
                <h4>Ссылка на подписку</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" type="text" class="validate client_group_link">
                        <label for="name" class="client_group_link_label">Ссылка</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <ul class="tabs">
                        @include('layouts.partials.groups-maintabs')
                    </ul>
                </ul>
            </div>
            <div id="lists" class="col s12">
                <div class="h10"></div>
                <a href="#modal1"
                   class="waves-effect waves-light light-blue darken-4 btn" {{ !$group->payed ? 'disabled' : '' }}>Добавить
                    список</a>
                <div class="mt20">
                    <table class="highlight">
                        <thead>
                        <th class="col s8">Имя</th>
                        <th class="col s4">Действия</th>
                        </thead>
                        <tbody>
                        @forelse($groups as $group)
                            <div id="modal_add_{{ $group->id }}" class="modal">
                                <div class="modal-content">
                                    <h4>Добавление пользователя</h4>
                                    <form action="{{ route('clientGroups.add.user') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="client_group_id" value="{{ $group->id }}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea id="users" name="users"
                                                          class="materialize-textarea textarea6"></textarea>
                                                <label for="users">Массовая загрузка пользователей (каждый с новой
                                                    строки)</label>
                                            </div>
                                        </div>
                                        <button class="waves-effect waves-green light-blue darken-4 btn">Добавить
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div id="modal_delete_{{ $group->id }}" class="modal">
                                <div class="modal-content">
                                    <h4>Массовое удаление пользователей</h4>
                                    <form action="{{ route('clientGroups.mass.delete.users') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="client_group_id" value="{{ $group->id }}">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea id="users" name="users"
                                                          class="materialize-textarea textarea6"></textarea>
                                                <label for="users">Id пользователей (каждый с новой строки)</label>
                                            </div>
                                        </div>
                                        <button class="waves-effect waves-green light-blue darken-4 btn">Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <tr>
                                <td class="col s8 table_td">
                                    <a href="{{ route('clientGroups.group', ['group_id' => $group->id]) }}">{{ $group->name }}</a>
                                </td>
                                <td class="col s4 table_td">
                                    <a class="waves-effect waves-light group_edit"
                                       data-edit-id="{{ $group->id }}"
                                       data-edit-name="{{ $group->name }}"
                                       data-need-show="{{ $group->show_in_list }}"
                                       href="#modal_edit">
                                        <i class="material-icons left">edit</i>
                                    </a>
                                    <a href="{{ route('clientGroups.delete.group', ['group_id' => $group->id]) }}"
                                       class="waves-effect waves-light"
                                       onclick="return confirm('Вы действительно хотите удалить этот список?')">
                                        <i class="material-icons left">delete</i>
                                    </a>
                                    <a href="#modal_add_{{ $group->id }}"
                                       class="waves-effect waves-light"
                                       title="Добавить пользователей">
                                        <i class="material-icons left">playlist_add</i>
                                    </a>
                                    <a href="#modal_delete_{{ $group->id }}"
                                       class="waves-effect waves-light"
                                       title="Удалить пользователей">
                                        <i class="material-icons left">remove_circle</i>
                                    </a>
                                    <a href="#modal_link"
                                       class="waves-effect waves-light link_group"
                                       data-link="{{"https://vk.com/app".env('COMMUNITY_APP_ID')."_-".$real_group_id."#".$group->id}}"
                                       title="Ссылка на подписку">
                                        <i class="material-icons left">link</i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="2">Списков не найдено</td>
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
                    $('.modal').modal();

                    $('#modal_payed').modal('open', {
                            dismissible: false
                        }
                    );

                    $(".need_show_in_app").on("change", function () {
                        var state = $(this).prop("checked");
                    });

                    $(".link_group").on('click', function () {
                        $('.client_group_link').val($(this).data('link'));
                        $(".client_group_link_label").addClass('active');
                    });

                    $(".group_edit").on("click", function () {
                        var group_id = $(this).data("editId"),
                            name = $(this).data("editName"),
                            checked = $(this).data('needShow');

                        $('.need_show_in_app_edit').prop('checked', checked);
                        $(".edit_group_id").val(group_id);
                        $(".edit_group_name_label").addClass('active');
                        $(".edit_group_name").val(name);
                    });
                });
            </script>
@stop