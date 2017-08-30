<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Подписка</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/materialize.css') }}">
    <style>
        body {
            width: 600px;
            height: 500px;
            overflow: hidden;
            overflow-y: scroll;
            background-color: #e4e5e6;
        }

        .wrap {
            width: 100%;
            padding: 20px;
        }


    </style>
</head>
<body>

<div class="wrap">
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>{{$Message}}</h5>
        </li>
        @foreach($list as $item)
            <li class="collection-item"><h5>{{$item}}</h5></li>
        @endforeach
    </ul>
    @if(isset($backUrl))
        <a href="{{$backUrl}}"> Назад </a>
    @endif
</div>
</body>
</html>
