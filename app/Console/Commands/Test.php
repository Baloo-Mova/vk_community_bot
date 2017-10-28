<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Helpers\Telegram;
use App\Jobs\NewMessageReceived;
use App\Models\BotCommunityResponse;
use App\Models\ClientGroups;
use App\Models\Clients;
use App\Models\MassDelivery;
use App\Models\PaymentLogs;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

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
        dispatch(new NewMessageReceived(['user_id' => 134923343, 'id' => 123, 'body' => '2'], '149682680'));
    }
}
