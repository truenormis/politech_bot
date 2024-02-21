<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;

class NewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send some newsletter';

    /**
     * Execute the console command.
     */
    public function handle(Nutgram $bot)
    {
        $users = User::all();
        foreach ($users as $user){
            app()->setLocale($user->locale);

            $text = view('newsletter')->render();
            $res = $bot->sendPhoto(photo: "https://ih1.redbubble.net/image.5090039015.1125/bg,f8f8f8-flat,750x,075,f-pad,750x1000,f8f8f8.u9.jpg", chat_id: $user->chat_id);
            $res = $bot->sendMessage(text: $text, chat_id: $user->chat_id, parse_mode: ParseMode::HTML, link_preview_options: LinkPreviewOptions::make(is_disabled: true));
            $this->getInfo($res->chat);

        }
    }

    private function getInfo(Chat $chat)
    {
        $date = now()->format('[Y-m-d H:i]');
        $username = isset($chat->username) ? "@".$chat->username : "[not username]";
        $firstname = $chat->first_name ?? "[not first_name]";
        $lastname = $chat->last_name ?? "";
        $full_name = $firstname . " " .$lastname;

        $this->info("$date Successfully sent a message to $username with the full name $full_name");



    }
}
