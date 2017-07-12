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
                        ['when_send', '<', Carbon::now()]
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

                $sendTo = [];
                foreach ($good as $item) {
                    if (in_array($item, $bad)) {
                        continue;
                    }
                    $sendTo[] = $item;
                }

                $vk->setGroup($this->task->group);

                foreach ($sendTo as $item) {
                    try {
                        $result = $vk->sendMessage($this->task->message, $item);
                        if (isset($result['error'])) {
                            Clients::where([
                                'vk_id'    => $item,
                                'group_id' => $this->task->group->id
                            ])->update(['can_send' => 0]);
                        }
                        usleep(500000);
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
                sleep(10);
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
