<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use Illuminate\Console\Scheduling\Schedule;

class MainMenu extends Menu
{
    protected string $name = 'main';

    function transfer()
    {
        $this->bot->sendMessage(text: __('messages.main'),reply_markup: $this->getKeyboard());
    }

    function run()
    {
        $this->bot->sendMessage(text: __('messages.main_error'), reply_markup: $this->getKeyboard());
    }
}
