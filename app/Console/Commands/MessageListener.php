<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\Clients;
use App\Models\ClientGroups;
use App\Models\Errors;
use App\Models\User;
use App\Models\UserGroups;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\IBMDB2\DB2Driver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class MessageListener extends Command
{
    public $httpClient;
    /**
     * @var UserGroups
     */
    public $group = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listener:start';
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
            //'proxy'  => '5.188.187.90:8000',
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

        $vk = new VK();
        while (true) {
            $this->group = null;
            try {
                DB::transaction(function () {
                    $this->group = UserGroups::where([
                        ['status', '=', '1'],
                        ['payed', '=', 1],
                        ['reserved', '=', 0]
                    ])->whereNotNull('token')->orderBy('last_time_checked', 'asc')->first();

                    if (isset($this->group)) {
                        $this->group->reserved = 1;
                        $this->group->save();
                    }
                });

                if ( ! isset($this->group)) {
                    sleep(10);
                    continue;
                }

                $vk->setGroup($this->group);
                $task = $this->group->activeTasks;
                $data = $task->mapWithKeys(function ($item) {
                    return [
                        $item['key'] => [
                            'response' => $item['response'],
                            'action'   => $item['action_id'],
                            'group'    => $item['add_group_id']
                        ]
                    ];
                });

                foreach ($vk->getUnseenDialogs()['items'] as $item) {
                    $messageId = $item['message']['id'];
                    $userId    = $item['message']['user_id'];
                    $body      = $item['message']['body'];

                    foreach ($data as $key => $value) {
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

                $this->group->last_time_checked = Carbon::now();
                $this->group->reserved          = 0;
                $this->group->save();
                sleep(5);
            } catch (\Exception $ex) {

                if (isset($this->group)) {
                    $this->group->reserved = 0;
                    $this->group->save();
                }

                $error       = new Errors();
                $error->text = $ex->getMessage() . '   ' . $ex->getLine();
                $error->url  = 'MessageListener';
                $error->save();
            }
        }
    }

    private function addToGroup($groupId, $userId)
    {
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

            if(!isset($user_info)){
                return false;
            }

            $client                  = new Clients();
            $client->client_group_id = $groupId;
            $client->vk_id           = $userId;
            $client->first_name      = $user_info["response"][0]["first_name"];
            $client->last_name       = $user_info["response"][0]["last_name"];
            $client->avatar          = $user_info["response"][0]["avatar"];
            $client->save();

            return true;
        }

        return false;
    }
}
