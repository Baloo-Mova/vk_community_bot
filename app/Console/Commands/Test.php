<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\BotCommunityResponse;
use App\Models\MassDelivery;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Console\Command;

class Test extends Command
{
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

        $test = "{\"type\":\"confirmation\",\"group_id\":56908702}";
        dd(json_decode($test));

        $user = UserGroups::find(2);
        $vk   = new VK();
        $vk->setGroup($user);
        $vk->setCallbackServer($user->group_id);
    }
}
