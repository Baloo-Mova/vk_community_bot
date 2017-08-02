<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\User;
use App\Models\UserGroups;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

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
        UserGroups::where('payed_for', '<', Carbon::now())->update([
            'payed'     => 0,
            'payed_for' => null,
            'status'    => 0
        ]);

        $groupsToNotify = UserGroups::where('payed_for', '<', Carbon::now()->addDays(1))->get();

        foreach ($groupsToNotify as $group) {
            $users = $group->users;
            $vk    = new VK();
            $vk->setGroup($group);
            $message = "Здравствуйте,
Вы получили это письмо, так как данная группа подключена к системе рассылки ВКонтакте Knocker.
До окончания срока подписки осталось менее 24 часов, после чего весь функционал прекратит свою работу. 
Чтобы не допустить этого, пожалуйста, продлите подписку на сайте http://vkknocker.ru
С уважением, Служба поддержки клиентов Knocker";
            foreach ($users as $user) {
                if ($user->resubscribe_notification_send == 0) {
                    $vk->sendMessage($message, $user->vk_id);
                    $user->resubscribe_notification_send = 1;
                    $user->save();
                }
            }
        }
    }
}
