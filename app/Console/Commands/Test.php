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
        $user = User::find(1);
        $order = PaymentLogs::find(242);

        if (!empty($order->promo_usage)) {

            if (empty($user->promo)) {
                $user->promo = $order->promo_usage;
                $user->increment('balance', config('promo_increment'));
                $user->save();
            }

            $promoUser = User::where(['my_promo' => $order->promo_usage])->first();

            if (isset($promoUser)) {
                $log = new PaymentLogs();
                $log->status = 1;
                $log->user_id = $promoUser->id;
                $log->description = PaymentLogs::PromoCodeUsage;
                $log->payment_sum = $order->payment_sum * (config('app.promo_percent') / 100);
                $log->save();

                $promoUser->increment('promo_balance', $order->payment_sum * (config('app.promo_percent') / 100));
                $promoUser->save();
            }
        }
    }
}
