<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\Errors;
use App\Models\UserGroups;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MessageListener extends Command
{
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
            try {
                $group = UserGroups::where([
                    ['status', '=', '1'],
                    ['payed', '=', 1],
                ])->whereNotNull('token')->orderBy('last_time_checked', 'desc')->first();

                if ( ! isset($group)) {
                    sleep(10);
                    continue;
                }

                $vk->setGroup($group);
                $task = $group->activeTasks;
                $data = $task->mapWithKeys(function ($item) {
                    return [$item['key'] => $item['response']];
                });

                foreach ($vk->getUnseenDialogs()['items'] as $item) {
                    $messageId = $item['message']['id'];
                    $userId    = $item['message']['user_id'];
                    $body      = $item['message']['body'];
                    $vk->setSeenMessage([$messageId], $userId);

                    foreach ($data as $key => $value) {
                        if (stripos($body, $key) !== false) {
                            $vk->sendMessage($value, $userId);
                            break;
                        }
                    }
                }

                $group->last_time_checked = Carbon::now();
                $group->save();
                sleep(5);
            } catch (\Exception $ex) {
                $error       = new Errors();
                $error->text = $ex->getMessage() . '   ' . $ex->getLine();
                $error->url  = 'MessageListener';
                $error->save();
            }
        }
    }
}
