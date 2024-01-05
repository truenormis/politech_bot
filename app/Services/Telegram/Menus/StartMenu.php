<?php

namespace App\Services\Telegram\Menus;

use App\Helpers\Md;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class StartMenu extends Menu
{
    protected string $name = 'start';
    function transfer()
    {
        $welcomeMessage = "<b>Добро пожаловать в бот Черниговской Политехники!</b> 🎓\n";
        $welcomeMessage .= "Я здесь, чтобы помочь вам получить актуальное расписание университета.\n";
        $welcomeMessage .= "Чтобы начать, необходимо выбрать группу.\n";
        $res = $this->bot->sendMessageHTML($this->user->chat_id,$welcomeMessage);
        new SetFacultyMenu($this->message);
    }

    function run()
    {
        new SetFacultyMenu($this->message);
    }
}
