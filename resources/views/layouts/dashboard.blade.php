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
            @if(Request::is('balance'))
                @include('layouts.partials.balanceheader')
            @else
                @include('layouts.partials.contentheader')
            @endif
            @yield('content')
        </main>

        @yield('css')

        @yield('js')
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        <script>
            $(document).ready(function(){
                $('.button-collapse').sideNav();

                $('.collapsible').collapsible();
            });
        </script>

    </body>

</html>
