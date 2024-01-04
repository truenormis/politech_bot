<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Services\Telegram\Menus\Menu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class ConfirmFalseMenu extends Menu
{
    protected string $name = 'init.confirm.false';

    function transfer()
    {
        $this->bot->sendMessage($this->user->chat_id,"Давайте попробуем заново заполнить данные 🔄");

        new SetFacultyMenu($this->message);
    }

    function run()
    {
        $this->bot->sendMessage($this->user->chat_id,"Давайте попробуем заново заполнить данные 🔄");

        new SetFacultyMenu($this->message);
    }
}
