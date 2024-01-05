<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class SetCourseMenu extends Menu
{
    protected string $name = 'init.set_course';
    function transfer()
    {
        $api = app(ApiService::class);
        $courses = $api->getCourses();
        $buttons = [];
        foreach ($courses as $course) {
            $callback = json_encode(['method' => 'set_course','data' => $course['Key']]);
            $buttons[] = ['text' => $course['Value'], 'callback_data' => $callback];
        }

        $buttons = array_chunk($buttons, 2);
        $keyboard = $this->bot->createInlineKeyboard($buttons);

        $this->bot->sendMessageHTML($this->user->chat_id,"Теперь выберите курс, на котором вы учитесь:",$keyboard);
    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,"⚠️ <b>Внимание!</b> Пожалуйста, выберите курс, на котором вы учитесь:");
    }
}
