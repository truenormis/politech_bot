<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Services\Telegram\Menus\Set\SetLocaleMenu;

class StartMenu extends Menu
{
    protected string $name = 'start';
    function transfer()
    {
        $welcomeMessage = __('messages.welcome');
        $res = $this->bot->sendMessageHTML($this->user->chat_id,$welcomeMessage);
        new SetLocaleMenu($this->message);
    }

    function run()
    {
        new SetFacultyMenu($this->message);
    }
}
