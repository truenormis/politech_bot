<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;

class SettingsMenu extends Menu
{
    protected string $name = 'settings';
    protected array $keyboard = [
        ['🔄 Изменить группу' => SetFacultyMenu::class],
        ['🏠 Главное Меню' => MainMenu::class],
    ];

    function transfer()
    {
        $this->bot->sendMessage($this->user->chat_id,"🛠️ Меню настроек\nЗдесь вы можете 📚 Изменить группу обучения",$this->getKeyboard());
    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage($this->user->chat_id,"Выберите пункт в меню 🤖",$this->getKeyboard());

    }
}
