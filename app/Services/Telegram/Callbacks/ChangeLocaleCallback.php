<?php

namespace App\Services\Telegram\Callbacks;

use App\Models\User;
use App\Services\Telegram\Menus\Set\SetEducationFormMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Services\Telegram\Menus\SettingsMenu;
use App\Telegram\Callback;
use App\Telegram\TelegramBot;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Nutgram;


class ChangeLocaleCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
        $bot = app(Nutgram::class);
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $user = auth()->user();
        $user->update(['locale' => $callback->data]);
        app()->setLocale($callback->data);
        new SettingsMenu();

    }
}
