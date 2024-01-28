<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class HelpMenu extends Menu
{
    protected string $name = 'help';
    function transfer()
    {
        $helpMessage = __('messages.help');
        $res = $this->bot->sendMessageHTML($this->user->chat_id,$helpMessage );
        //$res = $this->bot->sendMessage($this->user->chat_id,Md::escapeSpecialCharacters(""));
        new MainMenu($this->message);
    }

    function run()
    {
        new SetFacultyMenu($this->message);
    }
}
