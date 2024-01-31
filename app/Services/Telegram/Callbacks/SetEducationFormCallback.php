<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetCourseMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;
use SergiX44\Nutgram\Nutgram;

class SetEducationFormCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
        $bot = app(Nutgram::class);
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $user = auth()->user();
        $user->update(['education_form' => $callback->data]);
        new SetCourseMenu();
    }
}
