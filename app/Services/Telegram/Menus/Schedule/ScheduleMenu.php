<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Menu;

class ScheduleMenu extends Menu
{
    protected string $name = 'schedule';
    protected array $keyboard = [
        ['📅 Сегодняшнее расписание' => ScheduleTodayMenu::class],
        ['📆 Завтрашнее расписание' => ScheduleTomorrowMenu::class],
        ['🗓️ Расписание на эту неделю' => ScheduleThisWeekMenu::class],
        ['📆 Расписание на следующую неделю' => ScheduleNextWeekMenu::class],
        ['↩️ Вернуться в главное меню' => MainMenu::class],
    ];

    function transfer()
    {
        //dd($this->getKeyboard());
        $this->bot->sendMessageHTML($this->user->chat_id,"😊 Какое рассписание вы хотите посмотреть?",$this->getKeyboard());

    }

    function run()
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessageHTML(
            $this->user->chat_id,
            "Выберите пункт в меню, чтобы просмотреть соответствующее расписание. 📅📆🗓️",
            $this->getKeyboard()
        );
    }
}
