<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class HelpMenu extends Menu
{
    protected string $name = 'help';
    function transfer()
    {
        $helpMessage = "🤖 <b>Добро пожаловать в бот Черниговской Политехники!</b> 🎓\n\n";
        $helpMessage .= "Этот бот предназначен для получения расписания университета.\n";
        $helpMessage .= "Чтобы перемещаться по меню, выбирайте соответствующие пункты.\n";
        $helpMessage .= "В <b>настройках</b> вы можете сменить группу.\n\n";
        $res = $this->bot->sendMessageHTML($this->user->chat_id,$helpMessage );
        //$res = $this->bot->sendMessage($this->user->chat_id,Md::escapeSpecialCharacters(""));
        new MainMenu($this->message);
    }

    function run()
    {
        new SetFacultyMenu($this->message);
    }
}
