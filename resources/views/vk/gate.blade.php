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

        .collection-item {
            height: 56px;
        }

        .collection {
            border: none;
        }

        .collection-text {
            line-height: 2.5rem;
        }

        .special-button {
            width: 150px;
        }
    </style>

    <script src="https://vk.com/js/api/xd_connection.js?2" type="text/javascript"></script>
    <script type="text/javascript">

        var subscribeToId;

        function subscribe() {
            location.href = "{{url('/vk-app-subscribe/')}}/" + subscribeToId + "?backUrl=" + encodeURIComponent(location.href);
        }

        function unsubscribe(id) {
            location.href = "{{url('/vk-app-cancel/')}}/" + id + "?backUrl=" + encodeURIComponent(location.href);
        }

        function prepareData(id) {
            subscribeToId = id;

            @if($permission)
            subscribe();
            @else
            VK.callMethod("showAllowMessagesFromCommunityBox");
            @endif
        }

        VK.addCallback("onAllowMessagesFromCommunity", function () {
            subscribe();
        });

    </script>
</head>
<body>

<div class="wrap">
    <ul class="collection">
        @forelse($list as $item)
            <li class="collection-item">
                <span class="collection-text">{{$item['name']}}</span>
                <div class="secondary-content">
                    @if(!isset($item['client_id']))
                        <button class="special-button subscribe waves-effect waves-light light-blue darken-4 btn btn-small"
                                onclick="prepareData('{{$item['id']}}')">
                            Подписаться
                        </button>
                    @else
                        <button class="special-button unsubscribe waves-effect waves-light red darken-4 btn btn-small"
                                onclick="unsubscribe('{{$item['id']}}')">
                            Отписаться
                        </button>
                    @endif
                </div>
            </li>
        @empty
            <li class="collection-item" style="text-align: center;">
                Нет доступных групп :(
            </li>
        @endforelse
    </ul>
</div>
<script type="text/javascript" src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js')  }}"></script>
</body>
</html>
