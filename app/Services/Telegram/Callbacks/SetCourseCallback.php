<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetGroupMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;

class SetCourseCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {

        $bot = app(TelegramBot::class);
        $bot->deleteMessage($callback->message);
        $user = User::where('chat_id', $callback->message->chat->id)->first();
        $user->update(['course' => $callback->data]);

        new SetGroupMenu($callback->message);
    }
}
