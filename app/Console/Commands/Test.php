<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\BotCommunityResponse;
use App\Models\ClientGroups;
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
        $vk = new VK();
        $vk->setGroup(UserGroups::find(3));
        $result = $vk->sendMessage("adadasdad", 134123123);
        if (empty($result)) {
            Clients::where([
                'vk_id'    => 134123123,
                'group_id' => $this->task->group->group_id
            ])->update(['can_send' => 0]);
        }
    }
}
