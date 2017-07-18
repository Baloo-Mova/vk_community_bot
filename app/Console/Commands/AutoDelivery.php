<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\Clients;
use App\Models\Errors;
use Illuminate\Console\Command;
use League\Flysystem\Exception;
use malkusch\lock\mutex\FlockMutex;

class AutoDelivery extends Command
{
    /**
     * @var AutoDelivery[]|null
     */
    public $tasks = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:auto';
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
        while (true) {
            try {
                $this->tasks = \App\Models\AutoDelivery::with('group')->where('when_send', '<', time())->get();

                if ( ! isset($this->tasks)) {
                    sleep(10);
                    continue;
                }

                $vk = new VK();
                foreach ($this->tasks as $item) {
                    try {
                        $canSend = Clients::where([
                            'group_id' => $item->group->group_id,
                            'vk_id'    => $item->vk_id,
                            'can_send' => 1
                        ])->first();
                        if (isset($canSend)) {
                            $vk->setGroup($item->group);
                            $vk->sendMessage($item->message, $item->vk_id);
                        }
                        echo $item->vk_id . ' ' . $item->message;
                        $item->delete();
                    } catch (\Exception $ex) {
                        $err       = new Errors();
                        $err->text = $ex->getMessage();
                        $err->url  = $ex->getLine();
                        $err->save();
                    }
                }
                sleep(5);
            } catch (\Exception $exception) {
                $err       = new Errors();
                $err->text = $exception->getMessage();
                $err->url  = $exception->getLine();
                $err->save();
            }
        }
    }
}
