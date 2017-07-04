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
                                <tr>
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