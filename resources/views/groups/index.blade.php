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

        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="{{ $activated_groups_numb > 0 ? "active" : "" }}" href="#accessed">Группы с доступом</a>
                    </li>
                    <li class="tab col s3">
                        <a class="{{ $activated_groups_numb == 0 ? "active" : ""}}" href="#notaccessed">Разрешить доступ</a>
                    </li>
                </ul>
            </div>
            <div id="accessed" class="col s12 tab_content_custom">
                @foreach($activated_groups as $a_groups)
                        <div class="col s12 m6 l4 xl3">
                            <div class="card small">
                                <div class="card-content activator bots_card">
                                    <img src="{{ $a_groups->avatar }}"
                                         class="circle responsive-img group_avatar_in_card activator">
                                    <p class="card-title grey-text text-darken-4 group_name_in_card activator">{{ $a_groups->name }}</p>
                                    <p class="group_link_in_card activator">
                                        https://vk.com/club{{ $a_groups->group_id }}</p>
                                </div>
                                <div class="groups_options_card_wrap card-reveal">
                                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                                    <span class="card-title grey-text text-darken-4 small groups_options_card_title ">Настройки</span>
                                    <ul class="groups_options_card_ul">
                                        <li class="groups_options_card waves-effect wavev-dark">
                                            <a href="{{ route('groupSettings.index', ['id' => $a_groups->id]) }}"
                                               class="grey-text text-darken-2 a_non_decorated a_in_li">Перейти к настройкам</a>
                                        </li>
                                        <li class="groups_options_card waves-effect wavev-dark">
                                            <a href="{{ route('groups.delete.permissions', ['group_id' => $a_groups->id]) }}"
                                               class="grey-text text-darken-2 a_non_decorated a_in_li">Удалить доступ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            <div id="notaccessed" class="col s12 tab_content_custom">
                @foreach($non_activated_groups as $n_groups)
                        <div class="col s12 m6 l4 xl3">
                            <div class="card small">
                                <div class="card-content activator bots_card">
                                    <img src="{{ $n_groups->avatar }}"
                                         class="circle responsive-img group_avatar_in_card activator">
                                    <p class="card-title grey-text text-darken-4 group_name_in_card activator">{{ $n_groups->name }}</p>
                                    <p class="group_link_in_card activator">
                                        https://vk.com/club{{ $n_groups->group_id }}</p>
                                </div>
                                <div class="groups_options_card_wrap card-reveal">
                                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                                    <span class="card-title grey-text text-darken-4 small groups_options_card_title">Доступ</span>
                                    <ul class="groups_options_card_ul">
                                        <li class="groups_options_card waves-effect wavev-dark">
                                            <a href="{{ route('group.add', ['id' => $n_groups->group_id]) }}"
                                               class="grey-text text-darken-2 a_non_decorated a_in_li">Предоставить</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
@stop
