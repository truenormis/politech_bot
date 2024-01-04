<?php

namespace App\Services\Telegram\Menus\Set;

use App\Models\User;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;


class SetGroupMenu extends Menu
{
    protected string $name = 'init.set_group';
    function transfer()
    {
        $api = app(ApiService::class);
        $user = User::where('chat_id',$this->message->chat->id)->first();

        $groups = $api->getGroups($user->faculty,$user->education_form,$user->course);
        if (count($groups)){
            $buttons = [];
            foreach ($groups as $group) {
                $callback = json_encode(['method' => 'set_group','data' => $group['Key']]);
                $buttons[] = ['text' => $group['Value'], 'callback_data' => $callback];
            }

            $buttons = array_chunk($buttons, 2);
            $keyboard = $this->bot->createInlineKeyboard($buttons);

            $this->bot->sendMessageHTML($this->user->chat_id,"Теперь выберите свою группу, <i>[например 👥 КІ-221]</i>:",$keyboard);
        }else{
            $this->bot->sendMessageHTML($this->user->chat_id,"⚠️ <b>Ошибка!</b> Группа не была найдена. Пожалуйста, попробуйте ввести данные заново...");
            new SetFacultyMenu($this->message);
        }

    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,"⚠️ <b>Внимание!</b> Пожалуйста, выберите свою группу");
    }
}
