<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Menu;

class ScheduleMenu extends Menu
{
    protected string $name = 'schedule';


    function transfer()
    {
        //dd($this->getKeyboard());
        $this->bot->sendMessageHTML($this->user->chat_id,__("messages.schedule"),$this->getKeyboard());

    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessageHTML(
            $this->user->chat_id,
            __("message.schedule_error"),
            $this->getKeyboard()
        );
    }
}
