<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class SettingsMenu extends Menu
{
    protected string $name = 'settings';

    function transfer()
    {
        $this->bot->sendMessage($this->user->chat_id,__('messages.settings'),$this->getKeyboard());
    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage($this->user->chat_id,__('messages.settings_error'),$this->getKeyboard());

    }
}
