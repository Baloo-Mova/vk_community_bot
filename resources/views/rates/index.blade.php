@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        @section('contentheader_title')
            Тарифы
        @endsection
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Добавление</h4>
                <form action="{{ route('rate.add') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-field col s12">
                        <input name="name" id="rateName" type="text" class="validate">
                        <label for="rateName">Имя</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="price" id="price" type="text" class="validate">
                        <label for="price">Стоимость</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="days" id="days" type="text" class="validate">
                        <label for="days">Количество дней</label>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Добавить</button>
                </form>
            </div>
        </div>

        <div id="modal2" class="modal">
            <div class="modal-content">
                <h4>Редактирование</h4>
                <form action="{{ route('rate.edit') }}" class="scenario_edit_form" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" class="rate_id">
                    <div class="input-field col s12">
                        <input name="name" id="rateName" type="text" class="validate rate_name">
                        <label class="rate_name_label" for="rateName">Имя</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="price" id="price" type="text" class="validate rate_price">
                        <label class="rate_price_label" for="price">Стоимость</label>
                    </div>
                    <div class="input-field col s12">
                        <input name="days" id="days" type="text" class="validate rate_days">
                        <label class="rate_days_label" for="days">Количество дней</label>
                    </div>
                    <button class="waves-effect waves-green light-blue darken-4 btn">Сохранить</button>
                </form>
            </div>
        </div>

        <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn">Добавить</a>

        <table class="highlight">
            <thead>
            <th>Имя</th>
            <th>Стоимость</th>
            <th>Количество дней</th>
            <th>Действия</th>
            </thead>
            <tbody>
            @forelse($data as $resp)
                <tr>
                    <td>{{ $resp->name }}</td>
                    <td>{{ $resp->price }}</td>
                    <td>{{ $resp->days }}</td>
                    <td>
                        <a class="waves-effect waves-light rate_edit"
                           data-edit-id="{{ $resp->id }}"
                           data-edit-name="{{ $resp->name }}"
                           data-edit-days="{{ $resp->days }}"
                           data-edit-price="{{ $resp->price }}"
                           href="#modal2">
                            <i class="material-icons left">edit</i>
                        </a>
                        <a href="{{ route('rate.delete', ['id' => $resp->id]) }}"
                           class="waves-effect waves-light"
                           onclick="return confirm('Вы действительно хотите удалить этот тариф?')">
                            <i class="material-icons left">delete</i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="4">Нет записей</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.modal').modal();

            $(".rate_edit").on("click", function () {
                var id    = $(this).data("editId"),
                    name  = $(this).data("editName"),
                    days  = $(this).data("editDays"),
                    price = $(this).data("editPrice");

                $(".rate_id").val(id);
                $(".rate_name").val(name);
                $('.rate_name_label').addClass('active');
                $(".rate_days").val(days);
                $('.rate_days_label').addClass('active');
                $(".rate_price").val(price);
                $('.rate_price_label').addClass('active');
            });
        });
    </script>
@stop