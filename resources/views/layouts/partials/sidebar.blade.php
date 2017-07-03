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
                <a class="waves-effect" style="text-decoration: none;" href="{{ route('groups.index') }}">Группы</a>
            </li>

            <li id="categories_sub_category">
                <a class="waves-effect" style="text-decoration: none;" href="{{ route('balance.index') }}">Оплата</a>
            </li>
        </ul>
    </ul>
</ul>