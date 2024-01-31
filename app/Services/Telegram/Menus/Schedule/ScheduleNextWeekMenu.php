<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Helpers\MessageHelper;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use Carbon\Carbon;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use function Laravel\Prompts\text;

class ScheduleNextWeekMenu extends Menu
{
    protected string $name = 'schedule.nextweek';
    function transfer()
    {
        $api = app(ApiService::class);


        $schedule = $api->schedule($this->user->group)->getNextWeek();
        if (count($schedule)){
            $this->bot->sendMessage(text: MessageHelper::fromApiToTelegram($schedule), parse_mode: ParseMode::HTML);
        }else{
            $this->bot->sendMessage(__("messages.schedule_next_week"));
        }


        new ScheduleMenu();
    }

    function run()
    {
        $this->transfer();
    }
}
