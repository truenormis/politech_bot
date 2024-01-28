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

            $this->bot->sendMessageHTML($this->user->chat_id,__("messages.set_group"),$keyboard);
        }else{
            $this->bot->sendMessageHTML($this->user->chat_id,__("messages.group_not_found"));
            new SetFacultyMenu($this->message);
        }

    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,__("messages.set_group_error"));
    }
}
