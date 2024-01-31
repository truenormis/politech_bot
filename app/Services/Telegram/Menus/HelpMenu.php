<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class HelpMenu extends Menu
{
    protected string $name = 'help';
    function transfer()
    {
        $helpMessage = __('messages.help');
        $this->bot->sendMessage($helpMessage, parse_mode: ParseMode::HTML);
        new MainMenu();
    }

    function run()
    {
        new MainMenu();
    }
}
