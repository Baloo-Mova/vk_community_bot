@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <h1 class="page_title">
                Управление группами
                <span style="background-color: transparent;" class="contentheader_badge badge update_badge">
                        <a href="{{ route('groups.update') }}" class="update_user_groups_button">
                                    <span class="material-icons" title="Обновить группы">loop</span>
                                </a>
                    </span>
            </h1>
        </section>

<<<<<<< HEAD
                </h1>
            </section>

            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s3">
                            <a class="active" href="#accessed">Группы с доступом</a>
                        </li>
                        <li class="tab col s3">
                            <a href="#notaccessed">Разрешить доступ</a>
                        </li>
                    </ul>
                </div>
                <div id="accessed" class="col s12 tab_content_custom">
                    @foreach($groups as $activated_groups)
                        @if($activated_groups->token !== NULL)
                            <div class="col s12 m6 l4 xl3">
                                <div class="card small">
                                    <div class="card-content">
                                        <img src="{{ $activated_groups->avatar }}" class="circle responsive-img group_avatar_in_card">
                                        <p class="card-title grey-text text-darken-4 group_name_in_card">{{ $activated_groups->name }}</p>
                                        <i class="group_menu_activator_in_card activator material-icons right">more_vert</i>
                                        <p class="group_link_in_card">https://vk.com/club{{ $activated_groups->group_id }}</p>
                                        <span class="card-title activator grey-text text-darken-4">{{ $activated_groups->name }}<i class="material-icons right">more_vert</i></span>
                                    </div>
                                    <div class="groups_options_card_wrap card-reveal">
                                        <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                                        <span class="card-title grey-text text-darken-4 small groups_options_card_title ">Настройки</span>
                                        <ul class="groups_options_card_ul">
                                            <li class="groups_options_card waves-effect wavev-dark">
                                                <a href="{{ route('groups.response', ['bot_id' => $activated_groups->id]) }}" class="grey-text text-darken-2 a_non_decorated a_in_li">Сценарии ответов</a>
                                            </li>
                                        </ul>
                                    </div>
=======
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="active" href="#accessed">Группы с доступом</a>
                    </li>
                    <li class="tab col s3">
                        <a href="#notaccessed">Разрешить доступ</a>
                    </li>
                </ul>
            </div>
            <div id="accessed" class="col s12 tab_content_custom">
                @foreach($groups as $activated_groups)
                    @if($activated_groups->token !== null)
                        <div class="col s12 m6 l4 xl3">
                            <div class="card small">
                                <div class="card-content">
                                    <img src="{{ $activated_groups->avatar }}" class="circle responsive-img group_avatar_in_card">
                                    <p class="card-title grey-text text-darken-4 group_name_in_card">{{ $activated_groups->name }}</p>
                                    <i class="group_menu_activator_in_card activator material-icons right">more_vert</i>
                                    <p class="group_link_in_card">https://vk.com/club{{ $activated_groups->group_id }}</p>
                                    <span class="card-title activator grey-text text-darken-4">{{ $activated_groups->name }}
                                        <i class="material-icons right">more_vert</i></span>
                                </div>
                                <div class="groups_options_card_wrap card-reveal">
                                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                                    <span class="card-title grey-text text-darken-4 small groups_options_card_title ">Настройки</span>
                                    <ul class="groups_options_card_ul">
                                        <li class="groups_options_card waves-effect wavev-dark">
                                            <a href="{{ route('groups.response', ['bot_id' => $activated_groups->id]) }}" class="grey-text text-darken-2 a_non_decorated">Сценарии ответов</a>
                                        </li>
                                    </ul>
>>>>>>> d52b943f5a40dd186e36e69ec8f59108dab6e0a7
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div id="notaccessed" class="col s12 tab_content_custom">
                @foreach($groups as $activated_groups)
                    @if($activated_groups->token === null)
                        <div class="col s12 m6 l4 xl3">
                            <div class="card small">
                                <div class="card-content">
                                    <img src="{{ $activated_groups->avatar }}" class="circle responsive-img group_avatar_in_card">
                                    <p class="card-title grey-text text-darken-4 group_name_in_card">{{ $activated_groups->name }}</p>
                                    <i class="group_menu_activator_in_card activator material-icons right">more_vert</i>
                                    <p class="group_link_in_card">https://vk.com/club{{ $activated_groups->group_id }}</p>
                                </div>
                                <div class="groups_options_card_wrap card-reveal">
                                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                                    <span class="card-title grey-text text-darken-4 small groups_options_card_title">Доступ</span>
                                    <ul class="groups_options_card_ul">
                                        <li class="groups_options_card waves-effect wavev-dark">
                                            <a href="{{ route('group.add', ['id' => $activated_groups->group_id]) }}" class="grey-text text-darken-2 a_non_decorated">Предоставить</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
@endsection
