@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @section('contentheader_title')
        Настройки {{ $group->name }}
    @endsection

    <div class="row">
        <div class="col s12">
            <h1 class="bot_settings_title">Оплата подписки</h1>
            @if($group->payed == 1)
                <div class="col s12 m4 l4 xl4">
                    <div class="group_is_payed">
                    <span>
                      Подписка оплачена до <br>
                        {{ $group->payed_for }}
                  </span>
                    </div>
                </div>
            @else
                <div class="col s12 m6 l6 xl4">
                    <div class="group_not_payed">
                        <p>В данный момент подписка на бота не оплачена. </p>
                        <p>Стоимость подписки {{ config('robokassa.community_one_month_price') }} руб </p>
                    </div>
                    <form action="{{ route('groups.new.subscription') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <button class="btn waves-effect waves-light light-blue darken-4">Оплатить</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="col s12">
            <h1 class="bot_settings_title">Статус бота</h1>
            <form action="">
                <div class="switch">
                    <label>
                        <input {{ $group->payed == 0 ? 'disabled' : '' }}
                               {{ $group->status == 1 ? 'checked' : '' }}
                               data-group-id="{{ $group->id }}"
                               class="status_checkbox"
                               type="checkbox">
                        <span class="lever"></span>
                        <span class="bot_status">
                            {{ $group->status == 1 ? "бот включен" : "бот выключен" }}</span>
                    </label>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $(".status_checkbox").on("change", function(){
                var group_id = $(this).data('groupId'),
                    status = $(this).prop('checked');

                $.ajax({
                    method: "get",
                    url: "{{ url('/change-group-bot-status') }}/" + group_id + "/" + (status ? 1 : 0),
                    success: function (data) {
                        if(status){
                            $(".bot_status").text("бот включен");
                        }else{
                            $(".bot_status").text("бот выключен");
                        }
                    }
                });
            });

        });
    </script>

@stop
