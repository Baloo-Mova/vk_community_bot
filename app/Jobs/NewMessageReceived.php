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

class NewMessageReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data     = null;
    public $group_id = null;

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
                    if ($value['action'] == 1) {
                        $this->addToGroup($value['group'], $userId, $vk);
                    }
                    $vk->setSeenMessage([$messageId], $userId);
                    $vk->sendMessage($value['response'], $userId);
                    break;
                }
            }
        }
    }

    private function addToGroup($groupId, $userId, $vk)
    {
        $client = Clients::where([
            'vk_id'           => $userId,
            'client_group_id' => $groupId
        ])->first();
        if ( ! isset($client)) {
            $vk->setGroup($groupId);
            $user_info = $vk->getUserInfo($groupId, true);

            $client                  = new Clients();
            $client->client_group_id = $groupId;
            $client->vk_id           = $userId;
            $client->first_name      = $user_info["first_name"];
            $client->last_name       = $user_info["last_name"];
            $client->avatar          = $user_info["avatar"];
            $client->save();

            return true;
        }

        return false;
    }
}
