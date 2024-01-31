<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Services\Telegram\Menus\Menu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;

class ConfirmFalseMenu extends Menu
{
    protected string $name = 'init.confirm.false';

    function transfer()
    {
        $this->bot->sendMessage(__("messages.confirm_false"), reply_markup: ReplyKeyboardRemove::make(true));

        new SetFacultyMenu();
    }

    function run()
    {
        $this->transfer();
    }
}
