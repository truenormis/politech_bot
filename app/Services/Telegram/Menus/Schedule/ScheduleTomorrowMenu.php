<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class ScheduleTomorrowMenu extends Menu
{
    protected string $name = 'schedule.tomorrow';
    function transfer()
    {
        $api = app(ApiService::class);


        $scheduleTomorrow = $api->schedule($this->user->group)->getTomorrow()->toArray();
        if (count($scheduleTomorrow)){
            $groupedData = collect($scheduleTomorrow)->groupBy(['week_day', function (array $item) {
                return $item['study_time'];
            }], preserveKeys: true);
            dump($groupedData);
            $view = (string)view('schedule')->with(['data' => $groupedData]);
            //dump($view);
        }
        $this->bot->sendMessageHTML($this->user->chat_id,"Завтра пар нету 😊");
        new ScheduleMenu($this->message);
    }

    function run()
    {
        $api = app(ApiService::class);


        $scheduleToday = $api->schedule($this->user->group)->getToday()->toArray();

        $groupedData = collect($scheduleToday)->groupBy(['week_day', function (array $item) {
            return $item['study_time'];
        }], preserveKeys: true);
        dump($groupedData);
        $view = (string)view('schedule')->with(['data' => $groupedData]);
        //dump($view);
        $this->bot->sendMessageHTML($this->user->chat_id,$view);
        new ScheduleMenu($this->message);
    }
}
