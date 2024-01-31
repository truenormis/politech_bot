<?php

namespace App\Services\Telegram;

use App\Models\User;
use App\Services\Telegram\Menus\Confirm\ConfirmFalseMenu;
use App\Services\Telegram\Menus\Confirm\ConfirmMenu;
use App\Services\Telegram\Menus\Confirm\ConfirmTrueMenu;
use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleMenu;
use App\Services\Telegram\Menus\Schedule\ScheduleTodayMenu;
use App\Services\Telegram\Menus\Set\SetCourseMenu;
use App\Services\Telegram\Menus\Set\SetEducationFormMenu;
use App\Services\Telegram\Menus\Set\SetFacultyMenu;
use App\Services\Telegram\Menus\Set\SetGroupMenu;
use App\Services\Telegram\Menus\Set\SetLocaleMenu;
use App\Services\Telegram\Menus\SettingsMenu;
use App\Services\Telegram\Menus\StartMenu;
use App\Telegram\Message;
use Illuminate\Support\Arr;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Nutgram;
use function Laravel\Prompts\text;

class MenuHandlerFactory
{
    protected static $handlers = [
        'start' => StartMenu::class,

        'init.set_group' => SetGroupMenu::class,
        'init.set_faculty' => SetFacultyMenu::class,
        'init.set_education_form' => SetEducationFormMenu::class,
        'init.set_course' => SetCourseMenu::class,
        'init.set_locale' => SetLocaleMenu::class,
        'init.confirm' => ConfirmMenu::class,
        'init.confirm.true' => ConfirmTrueMenu::class,
        'init.confirm.false' => ConfirmFalseMenu::class,

        'main' => MainMenu::class,

        'settings' => SettingsMenu::class,

        'schedule' => ScheduleMenu::class,
        'schedule.today' => ScheduleTodayMenu::class,

        // Добавьте другие методы по мере необходимости
    ];

    public static function createHandler()
    {
        $menu = auth()->user()->menu;


        if (!Arr::has(static::$handlers, $menu)) {
            return new StartMenu();
        }

        $handlerClass = static::$handlers[$menu];

        return new $handlerClass();
    }
}
