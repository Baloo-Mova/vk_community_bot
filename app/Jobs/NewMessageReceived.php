<?php

namespace App\Jobs;

use App\Core\VK;
use App\Helpers\Telegram;
use App\Models\AutoDelivery;
use App\Models\Clients;
use App\Models\Errors;
use App\Models\Funnels;
use App\Models\FunnelsTime;
use App\Models\ListRules;
use App\Models\ModeratorLogs;
use App\Models\UserGroups;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;

class NewMessageReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data = null;
    public $group_id = null;
    public $httpClient = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $group_id)
    {
        $this->data = $data;
        $this->group_id = $group_id;
        $this->queue = "NewMessageReceived";

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $group = UserGroups::whereGroupId($this->group_id)->first();

        if (isset($group->token)) {
            $vk = new VK();
            $vk->setGroup($group);

            $task = $group->activeTasks;


            $res = $task->mapWithKeys(function ($item) {
                return [
                    $item['key'] => [
                        'id' => $item['id'],
                        'name' => $item['scenario_name'],
                        'response' => $item['response'],
                        'action' => $item['action_id'],
                        'group' => $item['add_group_id']
                    ]
                ];
            });


            $messageId = $this->data['id'];
            $userId = $this->data['user_id'];
            $body = $this->data['body'];
            $activeScenario = json_decode($group->send_scenario, true);
            if (!isset($activeScenario)) {
                $activeScenario = [];
            }

            if (array_key_exists('*', $res->toArray())) {
                if (isset($res["*"]['group'])) {
                    $this->addToGroup($res["*"]['group'], $userId);
                }
            }

            $clientIsset = Clients::where(['group_id' => $this->group_id, 'vk_id' => $userId])->first();

            if (!isset($clientIsset)) {
                $list = ListRules::where([
                    ['from', '<', Carbon::now()],
                    ['to', '>', Carbon::now()],
                    ['group_id', '=', $group->id]
                ])->get();

                foreach ($list as $item) {
                    $this->addToGroup($item->client_group_id, $userId);
                }
            }

            $actionId = "";
            foreach ($res as $key => $value) {
                if (mb_stripos(trim($body), trim($key), 0, "UTF-8") !== false) {
                    if (in_array($value['id'], $activeScenario)) {
                        $actionId = $value['name'];
                    }
                    switch ($value['action']) {
                        case 1:
                            $this->addToGroup($value['group'], $userId);
                            break;
                        case 2:
                            $this->deleteFromGroup($value['group'], $userId);
                            break;
                        case 3:
                            $this->deleteFromDB($this->group_id, $userId);
                            break;
                    }
                    $vk->setSeenMessage([$messageId], $userId);
                    $vk->sendMessage($value['response'], $userId);
                    break;
                }
            }


            if (!empty($actionId)) {
                $allowTranslate = json_decode($group->moderator_events, true);
                if (!isset($allowTranslate)) {
                    $allowTranslate = [];
                }
                if (in_array('message_new:scenario', $allowTranslate)) {
                    if ($group->show_in_history == 1) {
                        $this->httpClient = new Client([
                            'verify' => false,
                        ]);

                        $response = $this->httpClient->post('https://api.vk.com/method/users.get', [
                            'form_params' => [
                                'user_ids' => $userId,
                                'fields' => 'photo_100',
                                'v' => '5.67'
                            ]
                        ])->getBody()->getContents();

                        $user_info = json_decode($response, true);
                        $moderatorLogs = new ModeratorLogs();
                        $moderatorLogs->group_id = $group->id;
                        $moderatorLogs->event_id = 'message_new:scenario';
                        $moderatorLogs->vk_id = $userId;
                        $moderatorLogs->date = Carbon::now();
                        $moderatorLogs->name = $user_info["response"][0]["first_name"] . ' ' . $user_info["response"][0]["last_name"];
                        $user_message = "Пользователь <a href=\"http://vk.com/id" . $userId . "\">http://vk.com/id" . $userId . "</a> <br/>Отправил сообщение которое активировало сценарий: <b>" . $actionId . "</b> ";
                        $moderatorLogs->description = $user_message;
                        $moderatorLogs->save();
                    }
                    if ($group->send_to_telegram == 1) {
                        $telegram = new Telegram();
                        $user_message = date("H:i d.m.Y") . " \n*Пользователь* http://vk.com/id" . $userId . "\n*Отправил сообщение* активировавшее сценарий: *" . $actionId . "* \nГруппа: http://vk.com/club" . $group->group_id;
                        $telegram->sendMessage($group->telegram, $user_message);
                    }
                }
            }
        }
    }

    private function addToGroup($groupId, $userId)
    {
        $this->httpClient = new Client([
            'verify' => false,
        ]);

        $client = Clients::where([
            'vk_id' => $userId,
            'client_group_id' => $groupId
        ])->first();
        if (!isset($client)) {
            $response = $this->httpClient->post('https://api.vk.com/method/users.get', [
                'form_params' => [
                    'user_ids' => $userId,
                    'fields' => 'photo_100',
                    'v' => '5.67'
                ]
            ])->getBody()->getContents();

            $user_info = json_decode($response, true);

            if (isset($user_info['error'])) {
                return false;
            }

            $client = new Clients();
            $client->client_group_id = $groupId;
            $client->vk_id = $userId;
            $client->first_name = $user_info["response"][0]["first_name"];
            $client->last_name = $user_info["response"][0]["last_name"];
            $client->avatar = $user_info["response"][0]["photo_100"];
            $client->can_send = 1;
            $client->group_id = $this->group_id;
            $client->created = Carbon::now();
            $client->save();

            $funnel = Funnels::with('times')->where(['client_group_id' => $groupId])->get();
            $itemsToSend = [];
            foreach ($funnel as $item) {
                $itemsToSend = array_merge($itemsToSend, $item->times->toArray());
            }

            $autoSender = [];

            foreach ($itemsToSend as $itemSend) {
                $autoSender[] = [
                    'vk_id' => $userId,
                    'client_group_id' => $groupId,
                    'funnel_id' => $itemSend['id'],
                    'group_id' => $this->group_id,
                    'message' => $itemSend['text'],
                    'media' => $itemSend['media'],
                    'when_send' => time() + $itemSend['time'],
                ];
            }

            AutoDelivery::insert($autoSender);

            return true;
        }

        return false;
    }

    private function deleteFromGroup($groupId, $userId)
    {
        try {
            AutoDelivery::where(['vk_id' => $userId, 'client_group_id' => $groupId])->delete();
            Clients::where([
                'vk_id' => $userId,
                'client_group_id' => $groupId
            ])->delete();
            return true;
        } catch (\Exception $ex) {
            return false;
        }

    }

    private function deleteFromDB($groupId, $userId)
    {
        try {

            AutoDelivery::where(['vk_id' => $userId, 'group_id' => $groupId])->delete();

            Clients::where([
                'vk_id' => $userId,
                'group_id' => $groupId
            ])->delete();

            return true;
        } catch (\Exception $ex) {
            return false;
        }

    }
}
