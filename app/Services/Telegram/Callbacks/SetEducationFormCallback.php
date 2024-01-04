<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetCourseMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;

class SetEducationFormCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
        $bot = app(TelegramBot::class);
        $bot->deleteMessage($callback->message);
        $user = User::where('chat_id', $callback->message->chat->id)->first();
        $user->update(['education_form' => $callback->data]);
        new SetCourseMenu($callback->message);
    }
}
