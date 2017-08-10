<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Jobs\NewMessageReceived;
use App\Models\CallbackLog;
use App\Models\Clients;
use App\Models\Errors;
use App\Models\ModeratorLogs;
use App\Models\User;
use App\Models\UserGroups;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Helpers\Telegram;

class VkListenerController extends Controller
{
    public $httpClient = null;

    public function index(Request $request, $id)
    {
        $events_descriptions = [
            "photo_new" => "У Вас новая фотография от пользователя {user}",
            "photo_comment_new" => "У Вас новый комментарий к фотографии от пользователя {user}",
            "photo_comment_edit" => "Пользователь {user} редактировал комментарий к фотографии",
            "photo_comment_delete" => "Пользователь {user} удалил комментарий к фотографии",
            "photo_comment_restore" => "Пользователь {user} восстановил удаленный комментарий к фотографии",

            "audio_new" => "У Вас новая аудиозапись от пользователя {user}",

            "video_new" => "У Вас новая видеозапись от пользователя {user}",
            "video_comment_new" => "У Вас новый комментарий к видеозаписи от пользователя {user}",
            "video_comment_edit" => "Пользователь {user} редактировал комментарий к видеозаписи",
            "video_comment_delete" => "Пользователь {user} удалил комментарий к видеозаписи",
            "video_comment_restore" => "Пользователь {user} восстановил удаленный комментарий к видеозаписи",

            "wall_post_new" => "У Вас новая запись на стене от пользователя {user}",
            "wall_repost" => "У Вас новый репост от пользователя {user}",

            "wall_reply_new" => "У Вас новый комментарий на стене от пользователя {user}",
            "wall_reply_edit" => "Пользователь {user} редактировал комментарий на стене",
            "wall_reply_delete" => "Пользователь {user} удалил комментарий на стене",
            "wall_reply_restore" => "Пользователь {user} восстановил удаленный комментарий на стене",

            "board_post_new" => "У Вас новое обсуждение от пользователя {user}",
            "board_post_edit" => "Пользователь {user} редактировал обсуждение",
            "board_post_delete" => "Пользователь {user} удалил обсуждение",
            "board_post_restore" => "Пользователь {user} восстановил удаленное обсуждение",

            "market_comment_new" => "У Вас новый новый комментарий к товару от пользователя {user}",
            "market_comment_edit" => "Пользователь {user} редактировал комментарий к товару",
            "market_comment_delete" => "Пользователь {user} удалил комментарий к товару",
            "market_comment_restore" => "Пользователь {user} восстановил удаленный комментарий к товару",

            "group_join" => "Пользователь {user} вступил в сообщество",
            "group_leave" => "Пользователь {user} покинул сообщество",
            "group_change_settings" => "Пользователь {user} изменил настройки в сообществе",
            "poll_vote_new" => "Пользователь {user} оставил голос в публичном опросе",
            "group_change_photo" => "Пользователь {user} изменил главную фотографию сообщества",
            "group_officers_edit" => "Пользователь {user} изменил руководство сообщества",
        ];

        $addThisToList = $request->getContent();
        $item = new CallbackLog();
        $item->data = $addThisToList;
        $item->save();

        try {
            $data = json_decode($request->getContent(), true);
            $group = UserGroups::whereGroupId($data['group_id'])->first();
            if (!isset($group)) {
                echo "ok";
                exit();
            }

            if ($data['type'] == 'confirmation') {
                echo $group->success_response;
                exit();
            }

            if ($group->payed == 0 || $group->status == 0) {
                echo "ok";
                exit();
            }

            $user_message = str_replace("{user}", $data['object']['user_id'], $events_descriptions[$data['type']]);
            
            $this->httpClient = new Client([
                'verify' => false,
            ]);

            $response = $this->httpClient->post('https://api.vk.com/method/users.get', [
                'form_params' => [
                    'user_ids' => $data['object']['user_id'],
                    'fields' => 'photo_100',
                    'v' => '5.67'
                ]
            ])->getBody()->getContents();

            $user_info = json_decode($response, true);
            $moderatorLogs = new ModeratorLogs();
            $moderatorLogs->group_id = $group->id;
            $moderatorLogs->action_id = 0;
            $moderatorLogs->event_id = $data['type'];
            $moderatorLogs->vk_id = $data['object']['user_id'];
            $moderatorLogs->date = Carbon::now();
            $moderatorLogs->description = $user_message;
            $moderatorLogs->name = $user_info["response"][0]["first_name"] . ' ' . $user_info["response"][0]["last_name"];
            $moderatorLogs->save();

            if ($group->send_to_telegram == 1) {
                //send to teltegaramsd $user_message;
                $telegram = new Telegram();
                $telegram->sendMessage($group->id, $user_message);
            }


            switch ($data['type']) {
                case 'message_new':
                    $this->newMessageReceived($data['object'], $data['group_id'], $moderatorLogs);
                    break;
                case 'message_allow':
                    $this->setAllow($data['object']['user_id'], $data['group_id']);
                    break;
                case 'message_deny':
                    $this->setDeny($data['object']['user_id'], $data['group_id']);
                    break;
            }
        } catch (\Exception $ex) {
            $err = new Errors();
            $err->text = $ex->getMessage();
            $err->url = $ex->getLine();
            $err->save();
        }
        echo 'ok';
    }

    public function newMessageReceived($data, $group_id, $moderatorLogs)
    {
        $this->dispatch(new NewMessageReceived($data, $group_id, $moderatorLogs));
    }

    public function setAllow($id, $group_id)
    {
        try {
            Clients::where(['vk_id' => $id, 'group_id' => $group_id])->update(['can_send' => 1]);
        } catch (\Exception $ex) {
            $err = new Errors();
            $err->text = $ex->getMessage();
            $err->url = $ex->getLine();
            $err->save();
        }
    }

    public function setDeny($id, $group_id)
    {
        try {
            Clients::where(['vk_id' => $id, 'group_id' => $group_id])->update(['can_send' => 0]);
        } catch (\Exception $ex) {
            $err = new Errors();
            $err->text = $ex->getMessage();
            $err->url = $ex->getLine();
            $err->save();
        }
    }
}
