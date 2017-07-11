<?php

namespace App\Jobs;

use App\Core\VK;
use App\Models\Clients;
use App\Models\UserGroups;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;

class NewMessageReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data     = null;
    public $group_id = null;
    public $httpClient = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $group_id)
    {
        $this->data     = $data;
        $this->group_id = $group_id;
        $this->queue    = "NewMessageReceived";
        $this->httpClient = new Client([
            'proxy'  => '5.188.187.90:8000',
            'verify' => false,
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        file_put_contents("inf.txt", "1", FILE_APPEND);
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
            file_put_contents("inf.txt", "2", FILE_APPEND);
            foreach ($res as $key => $value) {
                if (mb_stripos(trim($body), trim($key), 0, "UTF-8") !== false) {
                    if ($value['action'] == 1) {
                        $this->addToGroup($value['group'], $userId);
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
        file_put_contents("inf.txt", "3", FILE_APPEND);
        $client = Clients::where([
            'vk_id'           => $userId,
            'client_group_id' => $groupId
        ])->first();
        if ( ! isset($client)) {
            $response = $this->httpClient->post('https://api.vk.com/method/users.get',
                ['form_params' => [
                    'user_ids' => $userId,
                    'fields'   => 'photo_100',
                    'v'        => '5.67'
                ]])->getBody()->getContents();

            $user_info = json_decode($response,true);

            if (isset($user_info['error'])) {
                return false;
            }

            $client                  = new Clients();
            $client->client_group_id = $groupId;
            $client->vk_id           = $userId;
            $client->first_name      = $user_info["response"][0]["first_name"];
            $client->last_name       = $user_info["response"][0]["last_name"];
            $client->avatar          = $user_info["response"][0]["photo_100"];
            $client->save();

            return true;
        }

        return false;
    }
}
