<ul id="slide-out" class="side-nav fixed z-depth-2">
    <li class="center no-padding">
        <div class="indigo darken-2 white-text" style="height: 180px;">
            <div class="row">
                <img style="margin-top: 5%;" src="{{$user->avatar}}" class="circle responsive-img" height="100" width="100">
                <p>
                    {{$user->FIO}}
                </p>
            </div>
        </div>
    </li>

    <ul class="collapsible" data-collapsible="accordion">
        <ul>
            <li id="categories_category">
                <a class="waves-effect {{ Request::is('/') || Request::is('group/*') ? 'blue-text text-darken-2' : '' }}"
                   style="text-decoration: none;"
                   href="{{ route('groups.index') }}">
                    <p><i class="material-icons">supervisor_account</i></p>
                    <p>Группы</p>
                </a>
            </li>

            <li id="categories_sub_category">
                <a class="waves-effect {{ Request::is('balance') || Request::is('balance/*') ? 'blue-text text-darken-2' : '' }}"
                   style="text-decoration: none;"
                   href="{{ route('balance.index') }}">
                    <p><i class="material-icons">account_balance_wallet</i></p>
                    <p>Оплата</p>
                </a>
            </li>

            <li id="categories_sub_category">
                <a class="waves-effect"
                   style="text-decoration: none;"
                   href="https://vk.me/vkknocker">
                    <p><i class="material-icons">live_help</i></p>
                    <p>Помощь</p>
                </a>
            </li>
        </ul>
    </ul>
</ul>