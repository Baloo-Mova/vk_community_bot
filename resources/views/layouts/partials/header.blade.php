<header>
    <ul class="dropdown-content" id="user_dropdown">
        <li>
            <a class="indigo-text" href="#!">Группы</a>
        </li>
        <li>
            <a class="indigo-text" href="#!">Баланс</a>
        </li>
        <li>
            <a class="indigo-text" href="#!">Помощь</a>
        </li>
        <li class="divider"></li>
        <li>
            <a class="indigo-text" href="#!">Выход</a>
        </li>
    </ul>

    <nav class="indigo" role="navigation">
        <div class="nav-wrapper">
            <a data-activates="slide-out" class="button-collapse show-on-" href="#!">
                <i class="material-icons">menu</i>
            </a>

            <ul class="right">
                <li>
                    <a class='right dropdown-button' href='' data-activates='user_dropdown'>
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