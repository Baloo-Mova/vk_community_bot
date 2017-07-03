<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\BotCommunityResponse;
use App\Models\User;
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
        $task = BotCommunityResponse::find(1);

        $vk = new VK();
        $vk->setGroup($task->group);
        //var_dump($vk->getUnseenDialogs());
        var_dump($vk->setSeenMessage([8],134923343));
    }
}
