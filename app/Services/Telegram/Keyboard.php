<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Menus\Change\ChangeLocaleMenu;
use App\Services\Telegram\Menus\Confirm\ConfirmFalseMenu;
use App\Services\Telegram\Menus\Confirm\ConfirmMenu;
use App\Services\Telegram\Menus\Confirm\ConfirmTrueMenu;
use App\Services\Telegram\Menus\HelpMenu;
use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Menu;
use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleNextWeekMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleThisWeekMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleTodayMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleTomorrowMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Services\Telegram\Menus\SettingsMenu;

class Keyboard
{
    private array $keyboards;

    public function __construct()
    {
        $this->keyboards = [
            MainMenu::class => [
                [__('keyboard.schedule') => ScheduleMenu::class],
                [__('keyboard.help') => HelpMenu::class],
                [__('keyboard.settings') => SettingsMenu::class],
            ],
            ScheduleMenu::class => [
                [
                    __('keyboard.today_schedule') => ScheduleTodayMenu::class,
                    __('keyboard.tomorrow_schedule') => ScheduleTomorrowMenu::class,
                ],
                [
                    __('keyboard.this_week_schedule') => ScheduleThisWeekMenu::class,
                    __('keyboard.next_week_schedule') => ScheduleNextWeekMenu::class,
                ],
//                [__('keyboard.today_schedule') => ScheduleTodayMenu::class],
//                [__('keyboard.tomorrow_schedule') => ScheduleTomorrowMenu::class],
//                [__('keyboard.this_week_schedule') => ScheduleThisWeekMenu::class],
//                [__('keyboard.next_week_schedule') => ScheduleNextWeekMenu::class],
                [__('keyboard.return_to_main_menu') => MainMenu::class],
            ],
            ConfirmMenu::class => [
                [
                    __('keyboard.yes') => ConfirmTrueMenu::class,
                    __('keyboard.no') => ConfirmFalseMenu::class,
                ],
            ],
            SettingsMenu::class => [
                [__('keyboard.change_group') => SetFacultyMenu::class],
                [__('keyboard.change_locale') => ChangeLocaleMenu::class],
                [__('keyboard.main_menu') => MainMenu::class],
            ],
        ];
    }

    public function getKeyboard(Menu $menu)
    {
        $menuClass = get_class($menu);
        if (isset($this->keyboards[$menuClass])) {
            return $this->keyboards[$menuClass];
        }
        return [];
    }
}
