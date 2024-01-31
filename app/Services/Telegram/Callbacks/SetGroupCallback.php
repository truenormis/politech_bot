<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Confirm\ConfirmMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;
use SergiX44\Nutgram\Nutgram;

class SetGroupCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {

        $bot = app(Nutgram::class);
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $user = auth()->user();
        $user->update(['group' => $callback->data]);
        //$bot->sendMessageHTML(1983524521, "");

        new ConfirmMenu();
    }
}
