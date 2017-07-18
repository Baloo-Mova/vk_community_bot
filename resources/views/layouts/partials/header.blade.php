<nav class=" blue darken-4">
    <div class="nav-wrapper">
        <ul class="left">
            <li><a href="javascript:void(0)" class="menu-collapse waves-effect waves-dark"><i class="material-icons">menu</i></a>
            </li>
        </ul>
        <ul class="right ">
            <li><a class='dropdown-button waves-effect waves-dark' href='#' data-activates='dropdown_message'><i
                            class="material-icons">notifications_active</i><!--<span class="counts">9+</span>--></a>
                <ul id='dropdown_message' class='dropdown-content messages collection'>
                    <li class="collection-item center-align">Нет новых уведомлений</li>
                </ul>
            </li>

            <li><a class='dropdown-button waves-effect waves-dark' href='#' data-activates='dropdown_mores'><i
                            class="material-icons">more_vert</i></a>
                <ul id='dropdown_mores' class='dropdown-content'>
                    <li>
                        <a href="{{ route('balance.index') }}" class="blue-text waves-effect">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            Баланс
                        </a>
                    </li>
                    <li>
                        <a href="https://vk.me/vkknocker" class="blue-text waves-effect">
                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                            Техподдержка
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="blue-text waves-effect">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Выход
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<nav class="breadcrumbnav  blue ">
    <div class="nav-wrapper ">
        <div class="col s12">
            <div class="left ">
                @if( Request::is('client-groups/group/*'))
                    <a href="{{ route('clientGroups.index', ['group_id' => $data->group_id]) }}">
                        Назад
                    </a>
                @endif
                @if( Request::is('funnels/show/*'))
                    <a href="{{ route('funnels.index', ['funnel_id' => $funnel->group_id]) }}">
                        Назад
                    </a>
                @endif
            </div>
            <div class="right template__badge-balance">
                <a href="{{ route('balance.index') }}">
                    <span class="teal lighten-2 badge white-text">{{ $user->balance }} р.</span>
                </a>
            </div>
        </div>
    </div>
</nav>