<?php

namespace App\Services\Telegram\Menus\Schedule;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class ScheduleNextWeekMenu extends Menu
{
    protected string $name = 'schedule.nextweek';
    function transfer()
    {
        $api = app(ApiService::class);


        $scheduleNextWeek = $api->schedule($this->user->group)->getNextWeek()->toArray();
        if (count($scheduleNextWeek)){
            $groupedData = collect($scheduleNextWeek)->groupBy(['week_day', function (array $item) {
                return $item['study_time'];
            }], preserveKeys: true);
            dump($groupedData);
            $view = (string)view('schedule')->with(['data' => $groupedData]);
            //dump($view);
            $this->bot->sendMessageHTML($this->user->chat_id,$view);
        }else{
            $this->bot->sendMessageHTML($this->user->chat_id,"На следующей неделе пар не будет 🤖");
        }


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
