@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Группа пользователей - {{ $data->name }} (Id {{ $group_id }})
        @endsection

        <div id="modal_add" class="modal">
            <div class="modal-content">
                <h4>Добавление пользователя</h4>
                <form action="{{ route('groups.add.client.group.user') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="client_group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="vk_id" id="vk_id" type="text" class="validate">
                            <label for="vk_id">Id пользователя</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="users" name="users" class="materialize-textarea textarea6"></textarea>
                            <label for="users">Масовая загрузка пользователей (каждый с новой строки)</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_delete" class="modal">
            <div class="modal-content">
                <h4>Массовое удаление пользователей</h4>
                <form action="{{ route('groups.mass.delete.client.group') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="client_group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="users" name="users" class="materialize-textarea textarea6"></textarea>
                            <label for="users">Id пользователей (каждый с новой строки)</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Удалить</button>
                </form>
            </div>
        </div>

        <div class="row">
            <a href="#modal_add" class="waves-effect waves-light light-blue darken-4 btn">Добавить пользователя</a>
            <a href="#modal_delete" class="waves-effect waves-light light-blue darken-4 btn">Удалить пользователей</a>
            <div class="col s12 mt20">
                <table class="highlight">
                    <thead>
                    <th class="col s8">Id пользователя</th>
                    <th class="col s4">Действия</th>
                    </thead>
                    <tbody>
                    @forelse($users as $item)
                        <tr>
                            <td class="col s8 table_td">
                                {{ $item->vk_id }}
                            </td>
                            <td class="col s4 table_td">
                                <a href="{{ route('groups.delete.client.group.user', ['user_id' => $item->id]) }}"
                                   class="waves-effect waves-light"
                                   onclick="return confirm('Вы действительно хотите удалить этого пользователя?')">
                                    <i class="material-icons left">delete</i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="2">Пользователей не найдено</td>
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
        });
    </script>

@stop