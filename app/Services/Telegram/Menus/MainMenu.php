<?php

namespace App\Services\Telegram\Menus;

use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use Illuminate\Console\Scheduling\Schedule;

class MainMenu extends Menu
{
    protected string $name = 'main';
    protected array $keyboard = [
        ['📅 Расписание' => ScheduleMenu::class],
        ['❓ Помощь' => HelpMenu::class], // Пункт "Помощь"
        ['⚙️ Настройки' => SettingsMenu::class] // Пункт "Настройки"
    ];

    function transfer()
    {
        $this->bot->sendMessage($this->user->chat_id,"🏠 Вы в главном меню",$this->getKeyboard());
    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage($this->user->chat_id,"Выберите пункт в меню",$this->getKeyboard());

    }
}
