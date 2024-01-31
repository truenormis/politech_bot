<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use function Laravel\Prompts\text;

class SettingsMenu extends Menu
{
    protected string $name = 'settings';

    function transfer()
    {
        $this->bot->sendMessage(text: __('messages.settings'), reply_markup: $this->getKeyboard());
    }

    function run()
    {

        $this->bot->sendMessage(text: __('messages.settings_error'),reply_markup: $this->getKeyboard());

    }
}
