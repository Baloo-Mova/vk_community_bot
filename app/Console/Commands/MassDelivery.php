<?php

namespace App\Console\Commands;

use App\Core\VK;
use App\Models\Clients;
use App\Models\Errors;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
                DB::transaction(function () {
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

                $good = array_column(Clients::whereIn('client_group_id', $rules['in'])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');
                $bad  = array_column(Clients::whereIn('client_group_id', $rules['not'])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');

                $sendTo = [];
                foreach ($good as $item) {
                    if (in_array($item, $bad)) {
                        continue;
                    }
                    $sendTo[] = $item;
                }

                $sendTo = array_chunk($sendTo, 99);

                $vk->setGroup($this->task->group);

                foreach ($sendTo as $sendArray) {
                    try {
                        $vk->massSend($this->task->message, $sendArray);
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
