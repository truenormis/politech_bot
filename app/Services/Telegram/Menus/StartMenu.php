<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Services\Telegram\Menus\Set\SetLocaleMenu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use function Laravel\Prompts\text;

class StartMenu extends Menu
{
    protected string $name = 'start';
    function transfer()
    {
        $welcomeMessage = __('messages.welcome');
        //$res = $this->bot->sendMessageHTML($this->user->chat_id,$welcomeMessage);
        $this->bot->sendMessage(text:$welcomeMessage,parse_mode: ParseMode::HTML);

        new SetLocaleMenu();
    }

    function run()
    {
        $welcomeMessage = __('messages.welcome');

        new SetFacultyMenu();

    }
}
