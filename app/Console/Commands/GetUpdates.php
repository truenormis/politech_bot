<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramDirector;
use App\Telegram\TelegramBot;
use App\Telegram\TelegramRequest;
use Illuminate\Console\Command;

class GetUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:get-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GetUpdates Telegram';

    /**
     * Execute the console command.
     */
    public function handle(TelegramBot $bot)
    {
        $update_id = $bot->getUpdateId();
        $this->info('Start id:'.$update_id);
        while (true){
            $new_update_id = $bot->getUpdateId();
            $this->info('New id:'.$new_update_id);
            $this->info('Old id:'.$update_id);
            if ($new_update_id>$update_id){
                $update_id = $new_update_id;
                $messages = $bot->getUpdates($update_id)->getMessages();

                foreach ($messages as $message){

                    new TelegramDirector($message);
                }
                $callbacks = $bot->getUpdates($update_id)->getCallbacks();
                //dd($callbacks);
            }
            sleep(2);


        }
    }
}
