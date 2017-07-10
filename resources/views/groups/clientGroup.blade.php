@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @section('contentheader_title')
        Группы пользователей
    @endsection

        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Добавление группы</h4>
                <form action="{{ route('groups.add.client.group') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate">
                            <label for="name">Имя</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_edit" class="modal">
            <div class="modal-content">
                <h4>Редактирование группы</h4>
                <form action="{{ route('groups.edit.client.group') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" class="edit_group_id">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate edit_group_name">
                            <label for="name" class="edit_group_name_label">Имя</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Редактировать</button>
                </form>
            </div>
        </div>

    <div class="row">
        <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn">Добавить группу</a>
        <div class="col s12 mt20">
            <table class="highlight">
                <thead>
                    <th class="col s8">Имя</th>
                    <th class="col s4">Действия</th>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td class="col s8 table_td">
                                <a href="{{ route('groups.clientGroupsUsers', ['group_id' => $group->id]) }}">{{ $group->name }}</a>
                            </td>
                            <td class="col s4 table_td">
                                <a class="waves-effect waves-light group_edit"
                                   data-edit-id="{{ $group->id }}"
                                   data-edit-name="{{ $group->name }}"
                                   href="#modal_edit">
                                    <i class="material-icons left">edit</i>
                                </a>
                                <a href="{{ route('groups.delete.client.group', ['group_id' => $group->id]) }}"
                                   class="waves-effect waves-light"
                                   onclick="return confirm('Вы действительно хотите удалить эту группу?')">
                                    <i class="material-icons left">delete</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="2">Групп не найдено</td>
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



            $(".group_edit").on("click", function () {
                var group_id = $(this).data("editId"),
                    name          = $(this).data("editName");

                $(".edit_group_id").val(group_id);
                $(".edit_group_name_label").addClass('active');
                $(".edit_group_name").val(name);
            });
        });
    </script>

@stop