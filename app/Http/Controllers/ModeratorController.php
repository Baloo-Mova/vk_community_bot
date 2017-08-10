<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroups;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class ModeratorController extends Controller
{

    public $events_icon = [
                            "message_new" => "fa fa-envelope-open",
                            "message_reply" => "fa fa-envelope-open",
                            "message_allow" => "fa fa-envelope-open",
                            "message_deny" => "fa fa-envelope-open",

                            "photo_new" => 'fa fa-picture-o',
                            "photo_comment_new" => "fa fa-picture-o",
                            "photo_comment_edit" => "fa fa-picture-o",
                            "photo_comment_delete" => "fa fa-picture-o",
                            "photo_comment_restore" => "fa fa-picture-o",

                            "audio_new" => "fa fa-headphones",

                            "video_new" => "fa fa-file-video-o",
                            "video_comment_new" => "fa fa-file-video-o",
                            "video_comment_edit" => "fa fa-file-video-o",
                            "video_comment_delete" => "fa fa-file-video-o",
                            "video_comment_restore" => "fa fa-file-video-o",

                            "wall_post_new" => "fa fa-pencil-square-o",
                            "wall_repost" => "fa fa-share",

                            "wall_reply_new" => "fa fa-comment",
                            "wall_reply_edit" => "fa fa-comment",
                            "wall_reply_delete" => "fa fa-comment",
                            "wall_reply_restore" => "fa fa-comment",

                            "board_post_new" => "fa fa-comments",
                            "board_post_edit" => "fa fa-comments",
                            "board_post_delete" => "fa fa-comments",
                            "board_post_restore" => "fa fa-comments",

                            "market_comment_new" => "fa fa-commenting",
                            "market_comment_edit" => "fa fa-commenting",
                            "market_comment_delete" => "fa fa-commenting",
                            "market_comment_restore" => "fa fa-commenting",

                            "group_join" => "fa fa-user-plus",
                            "group_leave" => "fa fa-user-times",
                            "group_change_settings" => "fa fa-cogs",
                            "poll_vote_new" => "fa fa-check-square-o",
                            "group_change_photo" => "fa fa-camera-retro",
                            "group_officers_edit" => "fa fa-list-ul",
                        ];

    public function index($group_id, $action_id)
    {
        $group = UserGroups::find($group_id);

        if(!isset($group->telegram) && !isset($group->telegram_keyword)){
            $group->telegram_keyword = md5(microtime(true));
            $group->save();
        }

        $events = $group->moderator_events == null ? [] : json_decode($group->moderator_events, true);

        if ($action_id == "all"){
            $logs =  $group->moderatorLogs()->paginate(10);
        }else{
            $logs =  $group->moderatorLogsSorted($action_id);
        }


        return view('moderator.index', [
            'group'         => $group,
            'actions'       => $group->actions,
            'events'        => $events,
            'events_icon'   => $this->events_icon,
            'events_number' => count($events),
            'logs'          => $logs,
            'action_id'     => $action_id,
            'user'          => \Auth::user()
        ]);
    }

    public function sorting($group_id, $id)
    {
        $group = UserGroups::find($group_id);
        if ($id == "all"){
            $events = $group->moderatorLogs;
        }else{
            $events = $group->moderatorLogsSorted($id);
        }

        if(!isset($events)){
            return "error";
        }else{
            return json_encode(["data" => $events, "icons" => $this->events_icon]);
        }
    }

    public function settings(Request $request)
    {
        $events = $request->get('event');
        $group_id = $request->get('group_id');
        $send_to_telegram = $request->get('send_to_telegram') ? 1 : 0;
        $group = UserGroups::find($group_id);

        if(!isset($events) || !isset($group_id)){
            Toastr::error('Пропущен обязательный параметр','Ошибка');
            return back();
        }

        if(!isset($group)){
            Toastr::error('Группа не найдена!','Ошибка');
            return back();
        }

        $events_str = '{';
        $position = 0;

        foreach ($events as $key=>$ev){
            if($position == 0){
                $events_str .= '"'.$key.'":1';
            }else{
                $events_str .= ',"'.$key.'":1';
            }
            $position = 1;
        }
        $events_str .= '}';
        $group->moderator_events = $events_str;
        if($group->telegram != null && $group->send_to_telegram != $send_to_telegram){
            $group->send_to_telegram = $send_to_telegram;
        }
        $group->save();
        Toastr::success('Изсенения сохранены','Сохранено');
        return back();
    }

}
