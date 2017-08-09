<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>Knocker - сервис умных рассылок ВКонтакте</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.partials.head')
</head>

    <body class="blue_theme side_fill">

    @include('layouts.partials.sidebar')

    <div class="page_wrapper">

        <div class="preloader__wrap">
            <div class="preloader-wrapper big active preloader__block">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>


        @include('layouts.partials.header')

        <div class=" page_content">
            @if(Request::is('balance') || Request::is('client-groups/group/*'))
                @include('layouts.partials.balanceheader')
            @elseif(Request::is('/') || Request::is('groups/*') || Request::path() == "in-work-page")
            @else
                @include('layouts.partials.contentheader')
            @endif
            @yield('content')
        </div>

    </div>

        @yield('css')

        <script type="text/javascript" src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
        <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        <script src="{{ asset('js/materialize.min.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/DateTimePicker.js') }}"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="{{ asset('js/DateTimePicker-ltie9.js') }}"></script>
        <![endif]-->
        <script type="text/javascript" src="{{ asset('js/DateTimePicker-i18n-ru.js') }}"></script>

        <!--Custome js-->
        <script type="text/javascript" src="{{ asset('js/rockon.js') }}"></script>
        @yield('js')

    </body>

</html>
