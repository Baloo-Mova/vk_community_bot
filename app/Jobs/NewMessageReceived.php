<?php

namespace App\Jobs;

use App\Core\VK;
use App\Models\AutoDelivery;
use App\Models\Clients;
use App\Models\Funnels;
use App\Models\FunnelsTime;
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

    public $data       = null;
    public $moderatorLogs       = null;
    public $group_id   = null;
    public $httpClient = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $group_id,$ml)
    {
        $this->data     = $data;
        $this->group_id = $group_id;
        $this->queue    = "NewMessageReceived";
        $this->moderatorLogs = $ml;
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
            $res  = $task->mapWithKeys(function ($item) {
                return [
                    $item['key'] => [
                        'response' => $item['response'],
                        'action'   => $item['action_id'],
                        'group'    => $item['add_group_id']
                    ]
                ];
            });

            $messageId = $this->data['id'];
            $userId    = $this->data['user_id'];
            $body      = $this->data['body'];

            foreach ($res as $key => $value) {
                if (mb_stripos(trim($body), trim($key), 0, "UTF-8") !== false) {
                    $this->moderatorLogs->action_id = $value;
                    switch ($value['action']){
                        case 1:
                            $this->moderatorLogs->action_id = 1;
                            $this->moderatorLogs->description = $this->moderatorLogs->description.'. По сценарию "Добавить в группу".';
                            $this->moderatorLogs->save();
                            $this->addToGroup($value['group'], $userId);
                            break;
                        case 2:
                            $this->moderatorLogs->action_id = 2;
                            $this->moderatorLogs->description = $this->moderatorLogs->description.'. По сценарию "Удалить из группы".';
                            $this->moderatorLogs->save();
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
        }
    }

    private function addToGroup($groupId, $userId)
    {
        $this->httpClient = new Client([
            'verify' => false,
        ]);

        $client = Clients::where([
            'vk_id'           => $userId,
            'client_group_id' => $groupId
        ])->first();
        if ( ! isset($client)) {
            $response = $this->httpClient->post('https://api.vk.com/method/users.get', [
                'form_params' => [
                    'user_ids' => $userId,
                    'fields'   => 'photo_100',
                    'v'        => '5.67'
                ]
            ])->getBody()->getContents();

            $user_info = json_decode($response, true);

            if (isset($user_info['error'])) {
                return false;
            }

            $client                  = new Clients();
            $client->client_group_id = $groupId;
            $client->vk_id           = $userId;
            $client->first_name      = $user_info["response"][0]["first_name"];
            $client->last_name       = $user_info["response"][0]["last_name"];
            $client->avatar          = $user_info["response"][0]["photo_100"];
            $client->can_send        = 1;
            $client->group_id        = $this->group_id;
            $client->created         = Carbon::now();
            $client->save();

            $funnel      = Funnels::with('times')->where(['client_group_id' => $groupId])->get();
            $itemsToSend = [];
            foreach ($funnel as $item) {
                $itemsToSend = array_merge($itemsToSend, $item->times->toArray());
            }

            $autoSender = [];

            foreach ($itemsToSend as $itemSend) {
                $autoSender[] = [
                    'vk_id'           => $userId,
                    'client_group_id' => $groupId,
                    'funnel_id'       => $itemSend['id'],
                    'group_id'        => $this->group_id,
                    'message'         => $itemSend['text'],
                    'when_send'       => time() + $itemSend['time'],
                ];
            }

            AutoDelivery::insert($autoSender);

            return true;
        }

        return false;
    }

    private function deleteFromGroup($groupId, $userId)
    {
        try{
            Clients::where([
                'vk_id'           => $userId,
                'client_group_id' => $groupId
            ])->delete();
            return true;
        }catch(\Exception $ex){
            return false;
        }

    }

    private function deleteFromDB($groupId, $userId)
    {
        try{

            AutoDelivery::where(['vk_id' => $userId, 'group_id' => $groupId])->delete();

            Clients::where([
                'vk_id'           => $userId,
                'group_id' => $groupId
            ])->delete();

            return true;
        }catch (\Exception $ex){
            return false;
        }

    }
}
