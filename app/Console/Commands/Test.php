<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\BotCommunityResponse;
use App\Models\Clients;
use App\Models\MassDelivery;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class Test extends Command
{
    public $httpClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->httpClient = new Client([
            'proxy' => '5.188.187.90:8000',
            'verify' => false,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = 342644021;
        $groupId = 149476726;

        $group = UserGroups::whereGroupId($groupId)->first();
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
                        $this->addToGroup($value['group'], $userId);
                    }
                    $vk->setSeenMessage([$messageId], $userId);
                    $vk->sendMessage($value['response'], $userId);
                    break;
                }
            }
        }
    }
}
