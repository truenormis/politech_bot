<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Services\Telegram\Menus\Menu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class ConfirmFalseMenu extends Menu
{
    protected string $name = 'init.confirm.false';

    function transfer()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,__("messages.confirm_false"));

        new SetFacultyMenu($this->message);
    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,__("messages.confirm_false"));

        new SetFacultyMenu($this->message);
    }
}
