<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Menu;
use function Laravel\Prompts\text;

class ScheduleMenu extends Menu
{
    protected string $name = 'schedule';


    function transfer()
    {
        //dd($this->getKeyboard());
        $this->bot->sendMessage(text: __("messages.schedule"), reply_markup: $this->getKeyboard());

    }

    function run()
    {
        $this->bot->sendMessage(text: __("messages.schedule_error"), reply_markup: $this->getKeyboard());
    }
}
