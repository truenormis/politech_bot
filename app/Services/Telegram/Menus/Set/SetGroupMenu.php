<?php

namespace App\Services\Telegram\Menus\Set;

use App\Models\User;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;


class SetGroupMenu extends Menu
{
    protected string $name = 'init.set_group';
    function transfer()
    {
        $api = app(ApiService::class);
        $user = auth()->user();

        $groups = $api->getGroups($user->faculty,$user->education_form,$user->course);
        if (count($groups)){
            $keyboard = InlineKeyboardMarkup::make();
            $buttonRow = [];
            foreach ($groups as $item) {
                $callback = json_encode(['method' => 'set_group','data' => $item['Key']]);
                $buttonRow[] = InlineKeyboardButton::make($item['Value'], callback_data: $callback);
                if (count($buttonRow) == 2) {
                    $keyboard->addRow(...$buttonRow);
                    $buttonRow = [];
                }
            }

            $this->bot->sendMessage(text: __("messages.set_group"), reply_markup: $keyboard);
        }else{
            $this->bot->sendMessage(text: __("messages.group_not_found"),parse_mode: ParseMode::HTML);
            new SetFacultyMenu();
        }

    }

    function run()
    {
        $this->bot->sendMessage(text: __("messages.set_group_error"),parse_mode: ParseMode::HTML);
    }
}
