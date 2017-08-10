<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroups;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class ModeratorController extends Controller
{

    public function index($group_id)
    {
        $group = UserGroups::find($group_id);

        if (!isset($group->telegram) && !isset($group->telegram_keyword)) {
            $group->telegram_keyword = md5(microtime(true));
            $group->save();
        }

        $events = $group->moderator_events == null ? [] : json_decode($group->moderator_events, true);
        $logs = $group->moderatorLogs()->paginate(10);

        $allEvents = [
            'message_new' => ['title' => 'Новое сообщение',],
            'audio_new' => ['title' => 'Новая аудиозапись',],
            'photo_new' => ['title' => 'Новое фото',],
            'video_new' => ['title' => 'Новое видео',],
            'group_join' => ['title' => 'Добавление участника',],
            'group_leave' => ['title' => 'Удаление участника',],
            'wall_post_new' => ['title' => 'Новая запись на стене',],
            'wall_reply_new' => ['title' => 'Новый коментарий на стене',],
            'wall_reply_edit' => ['title' => 'Редактирование коментария на стене',],
            'board_post_new' => ['title' => 'Новый коментарий в обсуждении',],
            'board_post_edit' => ['title' => 'Редактирование коментария в обсуждении',],
            'board_post_delete' => ['title' => 'Удаление коментария в обсуждении',],
            'board_post_restore' => ['title' => 'Восстановление коментария в обсуждении',],
            'photo_comment_new' => ['title' => 'Новый коментарий к фото',],
            'market_comment_new' => ['title' => 'Новый коментарий к товару',],
        ];

        foreach ($allEvents as $key => $item) {
            $allEvents[$key]['check'] = (in_array($key, $events) ? true : false);
        }

        return view('moderator.index', [
            'group' => $group,
            'allEvents' => $allEvents,
            'actions' => $group->actions,
            'logs' => $logs,
            'user' => \Auth::user()
        ]);
    }

    public function sorting($group_id, $id)
    {
        $group = UserGroups::find($group_id);
        if ($id == "all") {
            $events = $group->moderatorLogs;
        } else {
            $events = $group->moderatorLogsSorted($id);
        }

        if (!isset($events)) {
            return "error";
        } else {
            return json_encode(["data" => $events, "icons" => $this->events_icon]);
        }
    }

    public function settings(Request $request)
    {
        $events = $request->get('event');
        $group_id = $request->get('group_id');
        $send_to_telegram = $request->get('send_to_telegram') ? 1 : 0;

        $group = UserGroups::find($group_id);

        if (!isset($events) || !isset($group_id)) {
            Toastr::error('Пропущен обязательный параметр', 'Ошибка');
            return back();
        }

        if (!isset($group)) {
            Toastr::error('Группа не найдена!', 'Ошибка');
            return back();
        }

        $events_str = '{';
        $position = 0;

        foreach ($events as $key => $ev) {
            if ($position == 0) {
                $events_str .= '"' . $key . '":1';
            } else {
                $events_str .= ',"' . $key . '":1';
            }
            $position = 1;
        }
        $events_str .= '}';
        $group->moderator_events = $events_str;
        if ($group->telegram != null && $group->send_to_telegram != $send_to_telegram) {
            $group->send_to_telegram = $send_to_telegram;
        }

        $group->show_in_history = $request->get('show_in_history') ? 1 : 0;

        $group->save();
        Toastr::success('Изсенения сохранены', 'Сохранено');
        return back();
    }

}
