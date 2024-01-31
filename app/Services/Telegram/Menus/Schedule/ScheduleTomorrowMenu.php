<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Helpers\MessageHelper;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class ScheduleTomorrowMenu extends Menu
{
    protected string $name = 'schedule.tomorrow';
    function transfer()
    {
        $api = app(ApiService::class);


        $schedule = $api->schedule($this->user->group)->getTomorrow();
        if (count($schedule)){
            $this->bot->sendMessage(text: MessageHelper::fromApiToTelegram($schedule), parse_mode: ParseMode::HTML);
        }else{
            $this->bot->sendMessage(__("messages.schedule_this_week"));
        }
        new ScheduleMenu();
    }

    function run()
    {
        $this->transfer();
    }
}
