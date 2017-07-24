<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\Clients;
use App\Models\Errors;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use malkusch\lock\mutex\FlockMutex;

class MassDelivery extends Command
{
    public $task = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mass:delivery';
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
            $this->task = null;
            try {
                $mutex = new FlockMutex(fopen(__FILE__, "r"));
                $mutex->synchronized(function () {
                    $this->task = \App\Models\MassDelivery::where([
                        ['reserved', '=', 0],
                        ['sended', '=', 0],
                        ['when_send', '<', Carbon::now('Europe/Moscow')]
                    ])->first();

                    if (isset($this->task)) {
                        $this->task->reserved = 1;
                        $this->task->save();
                    }
                });

                if ( ! isset($this->task)) {
                    sleep(10);
                    continue;
                }

                $rules = json_decode($this->task->rules, true);
                $good  = array_column(Clients::whereIn('client_group_id',
                    $rules['in'])->where(['can_send' => 1])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');
                $bad   = array_column(Clients::whereIn('client_group_id',
                    $rules['not'])->where(['can_send' => 1])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');

                $sendTo = array_diff($good, $bad);

                $vk->setGroup($this->task->group);

                $sendTo = array_chunk($sendTo, 50);

                foreach ($sendTo as $item) {
                    try {
                        if (empty($vk->massSend($this->task->message, $item))) {
                            foreach ($item as $oneItem) {
                                $result = $vk->sendMessage($this->task->message, $oneItem);
                                if (empty($result)) {
                                    Clients::where([
                                        'vk_id'    => $oneItem,
                                        'group_id' => $this->task->group->group_id
                                    ])->update(['can_send' => 0]);
                                }
                                usleep(500000);
                            }
                        }
                        sleep(5);
                    } catch (\Exception $ex) {
                        $error       = new Errors();
                        $error->text = $ex->getMessage() . '   ' . $ex->getLine();
                        $error->url  = 'MassDeliverySEND';
                        $error->save();
                    }
                }

                $this->task->sended   = 1;
                $this->task->reserved = 0;
                $this->task->save();
                sleep(2);
            } catch (\Exception $ex) {
                $error       = new Errors();
                $error->text = $ex->getMessage() . '   ' . $ex->getLine();
                $error->url  = 'MassDelivery';
                $error->save();
            } finally {
                if (isset($this->task)) {
                    if ($this->task->sended == 0) {
                        $this->task->reserved = 0;
                        $this->task->save();
                    }
                }
            }
        }
    }

}
