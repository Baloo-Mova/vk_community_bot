@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @section('contentheader_title')
        Группы пользователей
    @endsection

        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Добавление группы</h4>
                
            </div>
        </div>

    <div class="row">
        <a href="#modal1" class="waves-effect waves-light light-blue darken-4 btn">Добавить группу</a>
        <div class="col s12">
            <table class="highlight">
                <thead>
                    <th>Имя</th>
                    <th>Действия</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                    </tr>
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