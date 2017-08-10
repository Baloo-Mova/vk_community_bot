<?php

namespace App\Console\Commands;

use App\Models\Errors;
use Illuminate\Console\Command;
use App\Helpers\Telegram;

class TelegramUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:updates';

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
        $telegram = new Telegram();
        while (true) {
            try {
                $telegram->getUpdates();
                sleep(3);
            } catch (\Exception $ex) {
                $err = new Errors();
                $err->text = $ex->getMessage() . " " . $ex->getLine();
                $err->url = "telegram";
                $err->save();
            }
        }
    }
}
