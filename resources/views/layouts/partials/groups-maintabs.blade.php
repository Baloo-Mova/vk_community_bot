<li class="tab col s2">
    <a class="{{ $tab_name == "settings" ? "active" : "" }}" target="_self"  href="{{ route('groupSettings.index', ['id' => $group_id]) }}">Настройки</a>
</li>
<li class="tab col s2">
    <a class="{{ $tab_name == "task" ? "active" : "" }}" target="_self"  href="{{ route('groupTasks.index', ['group_id' => $group_id]) }}">Сценарий ответов</a>
</li>
<li class="tab col s2">
    <a class="{{ $tab_name == "lists" ? "active" : "" }}" target="_self"  href="{{ route('clientGroups.index', ['group_id' => $group_id]) }}">Списки</a>
</li>
<li class="tab col s3">
    <a class="{{ $tab_name == "delivery" ? "active" : "" }}" target="_self"  href="{{ route('massDelivery.index', ['group_id' => $group_id]) }}">Рассылка</a>
</li>
<li class="tab col s3">
    <a class="{{ $tab_name == "funnels" ? "active" : "" }}" target="_self"  href="{{ route('funnels.index', ['group_id' => $group_id]) }}">Воронки</a>
</li>