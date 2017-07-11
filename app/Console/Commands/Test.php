<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\BotCommunityResponse;
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
        $this->httpClient = new Client([
            'proxy'  => '5.188.187.90:8000',
            'verify' => false,
        ]);
        $response = $this->httpClient->post('https://api.vk.com/method/user.get',
            ['form_params' => [
                'user_ids' => implode(',', ['342644021']),
                'fields'   => 'photo_100',
                'v'        => '5.67'
            ]])->getBody()->getContents();
        $info = json_decode($response);
        dd($info->response[0]);
        //$vk->getUserInfo(["342644021"], true);
        //$vk->setCallbackServer($user->group_id);
    }
}
