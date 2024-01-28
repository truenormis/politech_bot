<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use Illuminate\Console\Scheduling\Schedule;

class MainMenu extends Menu
{
    protected string $name = 'main';

    function transfer()
    {
        $this->bot->sendMessage($this->user->chat_id,__('messages.main'),$this->getKeyboard());
    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage($this->user->chat_id,__('messages.main_error'),$this->getKeyboard());

    }
}
