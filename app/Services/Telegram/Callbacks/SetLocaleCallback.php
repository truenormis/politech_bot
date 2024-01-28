<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetEducationFormMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;


class SetLocaleCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
        $bot = app(TelegramBot::class);
        $bot->deleteMessage($callback->message);
        $user = User::where('chat_id', $callback->message->chat->id)->first();
        $user->update(['locale' => $callback->data]);

        new SetFacultyMenu($callback->message);
    }
}
