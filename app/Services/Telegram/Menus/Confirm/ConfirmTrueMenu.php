<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Helpers\Md;
use App\Models\User;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\MainMenu;
use App\Services\Telegram\Menus\Menu;

class ConfirmTrueMenu extends Menu
{
    protected string $name = 'init.confirm.true';

    function transfer()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,"Сохраняю данные... 💾");

        new MainMenu($this->message);
    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,"Сохраняю данные... 💾");

        new MainMenu($this->message);
    }
}
