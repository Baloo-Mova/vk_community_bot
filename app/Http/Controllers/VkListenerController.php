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

            $allowTranslate = json_decode($group->moderator_events, true);
            if(!isset($allowTranslate)){
                $allowTranslate = [];
            }
            if (in_array($data['type'], $allowTranslate)) {
                $user_message = "";
                switch ($data['type']) {
                    case 'message_new':
                        $user_message = "Пользователь <a href=\"http://vk.com/id" . $data['object']['user_id'] . "\">http://vk.com/id" . $data['object']['user_id'] . "</a> <br/> Отправил сообщение: " . $data['object']['body'];
                        break;
                    case 'audio_new':
                        $user_message = "Новая аудиозапись <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'photo_new':
                        $user_message = "Новое фото <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'video_new':
                        $user_message = "Новое видео <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'group_join':
                        $user_message = "Новый пользователь <a href='http://vk.com/id" . $data['object']['user_id'] . "'>http://vk.com/id" . $data['object']['user_id'] . "</a> <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'group_leave':
                        $user_message = "Пользователь <a href='http://vk.com/id" . $data['object']['user_id'] . "'>http://vk.com/id" . $data['object']['user_id'] . "</a> <br/>Покинул группу: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'wall_post_new':
                        $user_message = "Новый пост <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'wall_reply_new':
                        $user_message = "Новый коментарий <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'wall_reply_edit':
                        $user_message = "Редактирование коментария <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'board_post_new':
                        $user_message = "Новое обсуждение <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'board_post_edit':
                        $user_message = "Редактирование обсуждения <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'board_post_delete':
                        $user_message = "Обсуждение удалено <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'board_post_restore':
                        $user_message = "Обсуждение восстановлено <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'photo_comment_new':
                        $user_message = "Новый коментарий к фото  <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                    case 'market_comment_new':
                        $user_message = "Новый коментарий к товару <br/>Группа: <a href=\"http://vk.com/club" . $data['group_id'] . "\">http://vk.com/club" . $data['group_id'] . "</a>";
                        break;
                }

                if ($group->show_in_history == 1) {
                    $name = "";
                    if (isset($data['object']['user_id'])) {
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
                        $name = $user_info["response"][0]["first_name"] . ' ' . $user_info["response"][0]["last_name"];
                    }
                    $moderatorLogs = new ModeratorLogs();
                    $moderatorLogs->group_id = $group->id;
                    $moderatorLogs->event_id = $data['type'];
                    $moderatorLogs->vk_id = isset($data['object']['user_id']) ? $data['object']['user_id'] : (isset($data['object']['from_id']) ? $data['object']['from_id'] : "");
                    $moderatorLogs->date = Carbon::now();
                    $moderatorLogs->name = $name;
                    $moderatorLogs->description = $user_message;
                    $moderatorLogs->save();
                }

                if ($group->send_to_telegram == 1) {
                    $user_message = "";
                    switch ($data['type']) {
                        case 'message_new':
                            $user_message = date("H:i d.m.Y") . " \n*Пользователь* http://vk.com/id" . $data['object']['user_id'] . "\n*Новое сообщение* в http://vk.com/club" . $data['group_id'] . "\n" . $data['object']['body'];
                            break;
                        case 'audio_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новая аудиозапись* \nГруппа: http://vk.com/club" . $data['group_id'];
                            break;
                        case 'photo_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новое фото* \nГруппа: http://vk.com/club" . $data['group_id'];
                            break;
                        case 'video_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новое видео* \nГруппа: http://vk.com/club" . $data['group_id'];
                            break;
                        case 'group_join':
                            $user_message = date("H:i d.m.Y") . " \n*Новый пользователь* http://vk.com/id" . $data['object']['user_id'] . "\nГруппа: http://vk.com/club" . $data['group_id'];
                            break;
                        case 'group_leave':
                            $user_message = date("H:i d.m.Y") . " \n*Пользователь* http://vk.com/id" . $data['object']['user_id'] . " покинул группу\nГруппа: http://vk.com/club" . $data['group_id'];
                            break;
                        case 'wall_post_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новый пост* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'wall_reply_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новый коментарий* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'wall_reply_edit':
                            $user_message = date("H:i d.m.Y") . " \n*Редактирование коментария* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'board_post_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новое обсуждение* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'board_post_edit':
                            $user_message = date("H:i d.m.Y") . " \n*Редактирование обсуждения* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'board_post_delete':
                            $user_message = date("H:i d.m.Y") . " \n*Обсуждение удалено* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'board_post_restore':
                            $user_message = date("H:i d.m.Y") . " \n*Обсуждение восстановлено* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'photo_comment_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новый коментарий к фото* в группе http://vk.com/club" . $data['group_id'];
                            break;
                        case 'market_comment_new':
                            $user_message = date("H:i d.m.Y") . " \n*Новый коментарий к товару* в группе http://vk.com/club" . $data['group_id'];
                            break;
                    }
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
