<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>Вк</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.partials.head')
</head>

    <body>

        @include('layouts.partials.sidebar')

        @include('layouts.partials.header')

        <main>
            @include('layouts.partials.contentheader')
            @yield('content')
        </main>

        @yield('css')

        @yield('js')
        <script>
            $(document).ready(function(){
                $('.button-collapse').sideNav();

                $('.collapsible').collapsible();
            });
        </script>
    </body>

</html>
