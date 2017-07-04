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
                            <td>{{ $group }}</td>
                            <td>2</td>
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
        });
    </script>

@stop