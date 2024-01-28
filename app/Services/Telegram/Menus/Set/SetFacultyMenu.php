<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class SetFacultyMenu extends Menu
{
    protected string $name = 'init.set_faculty';
    function transfer()
    {
        $api = app(ApiService::class);
        $faculties = $api->getFaculties();
        $buttons = [];
        foreach ($faculties as $faculty) {
            $faculty['Value'] = $faculty['Value'] == "Аспірантура_" ? "Аспірантура": $faculty['Value'];
            $callback = json_encode(['method' => 'set_faculty','data' => $faculty['Key']]);
            $buttons[] = ['text' => $faculty['Value'], 'callback_data' => $callback];
        }

        $buttons = array_chunk($buttons, 2);
        $keyboard = $this->bot->createInlineKeyboard($buttons);

        $this->bot->sendMessageHTML($this->user->chat_id,__('messages.set_faculty'),$keyboard);
    }

    function run()
    {
        $this->bot->sendMessageHTML(
            $this->user->chat_id,
            __('messages.set_faculty_error')
        );
    }
}
