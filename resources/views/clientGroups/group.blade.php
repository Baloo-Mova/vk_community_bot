@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('balanceheader_title')
            Группа пользователей - {{ $data->name }} (Id {{ $group_id }})
        @endsection
        @section('balanceheader_badge')
            {{ count($users) }} пользователей
        @endsection
        <div id="modal_add" class="modal">
            <div class="modal-content">
                <h4>Добавление пользователя</h4>
                <form action="{{ route('clientGroups.add.user') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="client_group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="users" name="users" class="materialize-textarea textarea6"></textarea>
                            <label for="users">Массовая загрузка пользователей (каждый с новой строки)</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_delete" class="modal">
            <div class="modal-content">
                <h4>Массовое удаление пользователей</h4>
                <form action="{{ route('clientGroups.mass.delete.users') }}" method="post">
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
                    <th class="col s3">Id</th>
                    <th class="col s3">Имя</th>
                    <th class="col s3">Фамилия</th>
                    <th class="col s2">Аватар</th>
                    <th class="col s1">Действия</th>
                    </thead>
                    <tbody>
                    @forelse($users as $item)
                        <tr>
                            <td class="col s3 table_td">
                                {{ $item->vk_id }}
                            </td>
                            <td class="col s3 table_td">
                                {{ $item->first_name }}
                            </td>
                            <td class="col s3 table_td">
                                {{ $item->last_name }}
                            </td>
                            <td class="col s2 table_td">
                                <img src="{{ $item->avatar }}" alt="" class="circle">
                            </td>
                            <td class="col s1 table_td">
                                <a href="{{ route('clientGroups.delete.user', ['user_id' => $item->id]) }}"
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