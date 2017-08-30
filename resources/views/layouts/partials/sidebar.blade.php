<ul id="slide-out" class="side-nav fixed">
    <li class="usernavitem">
        <div class="userView center-align">
            <a href="#!" class="menuclosebtn white-text"><i class="material-icons">keyboard_backspace</i></a>
            <img class="background" src="{{ asset('img/sidebar.png') }}" alt="">
            <a href="#" class="center-align picture">
                <img class="circle sidebar_logo" src="{{ asset('img/logo.svg') }}" alt="">
            </a>
            <a href="#">
                <span class="white-text name site_name_in_sidebar">Knocker</span>
            </a>
        </div>
    </li>
    <li class="{{ Request::is('/') || Request::is('group/*')
                || Request::is('group-settings/*') || Request::is('group-tasks/*')
                || Request::is('client-groups/*') || Request::is('mass-delivery/*') ? 'active' : '' }}">
        <a href="{{ route('groups.index') }}" class="waves-effect waves-grey">
            <i class="fa fa-users  fa-2x sidebar_icon" aria-hidden="true"></i>
            Подключенные группы
        </a>
    </li>
    <li class="">
        <a href="https://vk.com/add_community_app?aid={{env('COMMUNITY_APP_ID','')}}" class="waves-effect waves-grey">
            <i class="fa fa-users  fa-2x sidebar_icon" aria-hidden="true"></i>
            Добавить приложение групп
        </a>
    </li>
    <li class="{{ Request::is('balance') || Request::is('balance/*') ? 'active' : '' }}">
        <a href="{{ route('balance.index') }}" class="waves-effect waves-grey">
            <i class="fa fa-credit-card-alt  fa-2x sidebar_icon" aria-hidden="true"></i>
            Баланс
        </a>
    </li>
    <li>
        <a href="https://vk.me/vkknocker" class="waves-effect waves-grey">
            <i class="fa fa-question-circle  fa-2x sidebar_icon" aria-hidden="true"></i>
            Техподдержка
        </a>
    </li>
    <li class="nonactive">
        <a href="{{ route('inwork') }}" class="waves-effect waves-grey">
            <i class="fa fa-percent  fa-2x sidebar_icon" aria-hidden="true"></i>
            Партнерская программа
        </a>
    </li>
    <li class="nonactive">
        <a href="{{ route('inwork') }}" class="waves-effect waves-grey nonactive">
            <i class="fa fa-graduation-cap fa-2x sidebar_icon" aria-hidden="true"></i>
            Уроки по сервису
        </a>
    </li>
    <li class="nonactive">
        <a href="https://vk.com/topic-149816340_35569562" class="waves-effect waves-grey">
            <i class="fa fa-lightbulb-o fa-2x sidebar_icon" aria-hidden="true"></i>
            Ваши предложения
        </a>
    </li>

@if(Auth::user()->id == 2)
    <hr/>
    <li class="nonactive">
        <a href="{{route('rate.index')}}" class="waves-effect waves-grey">
            <i class="fa fa-cogs fa-2x sidebar_icon" aria-hidden="true"></i>
            Тарифы
        </a>
    </li>
@endif
</ul>