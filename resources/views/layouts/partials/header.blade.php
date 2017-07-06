<header>
    <ul class="dropdown-content user_dropdown_ul" id="user_dropdown">
        <li>
            <a class="indigo-text header_user_menu_item" href="{{ route('groups.index') }}">Группы</a>
        </li>
        <li>
            <a class="indigo-text header_user_menu_item" href="{{ route('balance.index') }}">Баланс</a>
        </li>
        <li>
            <a class="indigo-text header_user_menu_item" href="https://vk.me/vkknocker">Помощь</a>
        </li>
        <li class="divider"></li>
        <li>

            <a class="indigo-text header_user_menu_item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                Выход
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>

    <nav class="indigo" role="navigation">
        <div class="nav-wrapper">
            <a data-activates="slide-out" class="button-collapse show-on-" href="#!">
                <i class="material-icons">menu</i>
            </a>

            <ul class="right">
                <li>
                    <a class='right dropdown-button header_user' href='' data-activates='user_dropdown'>
                        <span>
                            {{$user->FIO}}
                        </span>
                    </a>
                </li>
            </ul>

            <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        </div>
    </nav>
</header>