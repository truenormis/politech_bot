<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetEducationFormMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;
use SergiX44\Nutgram\Nutgram;


class SetFacultyCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
        $bot = app(Nutgram::class);
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $user = auth()->user();
        $user->update(['faculty' => $callback->data]);

        new SetEducationFormMenu();
    }
}
