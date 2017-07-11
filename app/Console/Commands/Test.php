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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = 342644021;
        $groupId = 2;

        $this->httpClient = new Client([
            'proxy' => '5.188.187.90:8000',
            'verify' => false,
        ]);

        $client = Clients::where([
            'vk_id' => $userId,
            'client_group_id' => $groupId
        ])->first();

        if (!isset($client)) {
            $response = $this->httpClient->post('https://api.vk.com/method/users.get',
                ['form_params' => [
                    'user_ids' => $userId,
                    'fields' => 'photo_100',
                    'v' => '5.67'
                ]])->getBody()->getContents();

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
            $client->save();

            return true;
        }
    }
}
