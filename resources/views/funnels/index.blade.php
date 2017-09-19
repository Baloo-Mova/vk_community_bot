@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Воронки
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

        <div id="modal1" class="modal" style="overflow: visible !important;">
            <div class="modal-content">
                <h4>Добавление воронки</h4>
                <form action="{{ route('funnels.add') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" value="{{ $group_id }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate">
                            <label for="name">Имя</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="client_group_id" class="client_group_id">
                                <option value="" disabled selected>Выберите список</option>
                                @forelse($client_groups as $gr)
                                    <option value="{{ $gr->id }}">{{ $gr->name }}</option>
                                    @empty
                                    <option value="" disabled>Списки отсутствуют</option>
                                @endforelse
                            </select>
                            <label for="client_group_id">Список</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn" >Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal_edit" class="modal" style="overflow: visible !important;">
            <div class="modal-content">
                <h4>Редактирование воронки</h4>
                <form action="{{ route('funnels.edit') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="funnel_id" class="edit_funnel_id">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate edit_funnel_name">
                            <label for="name" class="edit_funnel_name_label">Имя</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="client_group_id" id="client_edit_group_id" class="client_edit_group_id">
                                <option value="" disabled selected>Выберите список</option>
                                @forelse($client_groups as $gr)
                                    <option value="{{ $gr->id }}">{{ $gr->name }}</option>
                                @empty
                                    <option value="" disabled>Списки отсутствуют</option>
                                @endforelse
                            </select>
                            <label for="client_edit_group_id">Список</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Редактировать</button>
                </form>
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
                <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn" {{ !$group->payed ? 'disabled' : '' }}>Добавить воронку</a>
                <div class="mt20">
                    <table class="highlight">
                        <thead>
                            <th class="col s8">Имя</th>
                            <th class="col s2">Список</th>
                            <th class="col s2">Действия</th>
                        </thead>
                        <tbody>
                            @forelse($funnels as $funnel)
                                <tr class="funnels_tr">
                                    <td class="col s8 funnels_td">
                                        <a href="{{ route('funnels.show', ['funnel_id' => $funnel->id]) }}" class="funnel_link">{{ $funnel->name }}</a>
                                    </td>
                                    <td class="col s2 funnels_td">
                                        <div>
                                            {{ $funnel->clientGroup->name}}
                                        </div>
                                    </td>
                                    <td class="col s2 funnels_td">
                                        <a href="{{ route('funnels.delete', ['funnel_id' => $funnel->id]) }}"
                                           class="waves-effect waves-light funnel_action"
                                           onclick="return confirm('Вы действительно хотите удалить эту воронку?')">
                                            <i class="material-icons left">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="2">Воронок не найдено!</td>
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
                    $(".client_group_id").material_select();
                    $(".client_edit_group_id").material_select();
                    $('.modal').modal();

                    $('#modal_payed').modal('open',{
                            dismissible: false
                        }
                    );
                });
                $(".funnel_edit").on("click", function () {
                    var funnel_id = $(this).data("editId"),
                        name          = $(this).data("editName");
                        clgr          = $(this).data("editClgr");

                    $(".edit_funnel_id").val(funnel_id);
                    $(".edit_funnel_name_label").addClass('active');
                    $(".edit_funnel_name").val(name);

                    $(".client_edit_group_id").material_select('destroy');
                    $(".client_edit_group_id").val(clgr);
                    $(".client_edit_group_id").material_select();
                });
            </script>
@stop