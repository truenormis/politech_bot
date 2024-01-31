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
        $this->bot->sendMessage(__("messages.confirm_true"));

        new MainMenu();
    }

    function run()
    {
        $this->transfer();
    }
}
