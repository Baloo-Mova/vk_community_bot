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

            $allowTranslate = json_decode($group->moderator_events);
            if (in_array($data['type'], $allowTranslate)) {
                $user_message = "";
                switch ($data['type']) {
                    case 'message_new':
                        $user_message = date("H:i d.m.Y") . " \nПользователь http://vk.com/id" . $data['object']['user_id'] . "\nНовое сообщение в http://vk.com/club" . $data['group_id'] . "\n" . $data['object']['body'];
                        break;
                    case 'audio_new':
                        $user_message = date("H:i d.m.Y") . " \nНовая аудиозапись \nГруппа: http://vk.com/club" . $data['group_id'];
                        break;
                    case 'photo_new':
                        $user_message = date("H:i d.m.Y") . " \nНовое фото https://vk.com/photo" . $data['object']['owner_id'] . "_" . $data['object']['id'] . "\nГруппа: http://vk.com/club" . $data['group_id'];
                        break;
                    case 'video_new':
                        $user_message = date("H:i d.m.Y") . " \nНовое видео \nГруппа: http://vk.com/club" . $data['group_id'];
                        break;
                    case 'group_join':
                        $user_message = date("H:i d.m.Y") . " \nНовый пользователь http://vk.com/id" . $data['object']['user_id'] . "\nГруппа: http://vk.com/club" . $data['group_id'];
                        break;
                    case 'group_leave':
                        $user_message = date("H:i d.m.Y") . " \nПользователь http://vk.com/id" . $data['object']['user_id'] . "покинул группу\nГруппа: http://vk.com/club" . $data['group_id'];
                        break;
                    case 'wall_post_new':
                        $user_message = date("H:i d.m.Y") . " \nНовый пост в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'wall_reply_new':
                        $user_message = date("H:i d.m.Y") . " \nНовый коментарий в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'wall_reply_edit':
                        $user_message = date("H:i d.m.Y") . " \nРедактирование коментария в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'board_post_new':
                        $user_message = date("H:i d.m.Y") . " \nНовое обсуждение в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'board_post_edit':
                        $user_message = date("H:i d.m.Y") . " \nРедактирование обсуждения в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'board_post_delete':
                        $user_message = date("H:i d.m.Y") . " \nОбсуждение удалено в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'board_post_restore':
                        $user_message = date("H:i d.m.Y") . " \nОбсуждение восстановлено в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'photo_comment_new':
                        $user_message = date("H:i d.m.Y") . " \nНовый коментарий к фото в группе http://vk.com/club" . $data['group_id'];
                        break;
                    case 'market_comment_new':
                        $user_message = date("H:i d.m.Y") . " \nНовый коментарий к товару в группе http://vk.com/club" . $data['group_id'];
                        break;
                }

                if ($group->show_in_history == 1) {
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
                    $moderatorLogs->event_id = $data['type'];
                    $moderatorLogs->vk_id = $data['object']['user_id'];
                    $moderatorLogs->date = Carbon::now();
                    $moderatorLogs->name = $user_info["response"][0]["first_name"] . ' ' . $user_info["response"][0]["last_name"];
                    $moderatorLogs->description = $user_message;
                    $moderatorLogs->save();
                }

                if ($group->send_to_telegram == 1) {
                    $telegram = new Telegram();
                    $telegram->sendMessage($group->telegram, $user_message);
                }
            }

            switch ($data['type']) {
                case 'message_new':
                    $this->newMessageReceived($data['object'], $data['group_id']);
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

    public function newMessageReceived($data, $group_id)
    {
        $this->dispatch(new NewMessageReceived($data, $group_id));
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
