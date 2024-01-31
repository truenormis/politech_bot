<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class SetFacultyMenu extends Menu
{
    protected string $name = 'init.set_faculty';

    function transfer()
    {
        $api = app(ApiService::class);
        $faculties = $api->getFaculties();
        $keyboard = InlineKeyboardMarkup::make();
        $buttonRow = [];
        foreach ($faculties as $faculty) {
            $faculty['Value'] = $faculty['Value'] == "Аспірантура_" ? "Аспірантура" : $faculty['Value'];
            $callback = json_encode(['method' => 'set_faculty', 'data' => $faculty['Key']]);
            $buttonRow[] = InlineKeyboardButton::make($faculty['Value'], callback_data: $callback);
            if (count($buttonRow) == 2) {
                $keyboard->addRow(...$buttonRow);
                $buttonRow = [];
            }
        }
        if (!empty($buttonRow)) {
            $keyboard->addRow(...$buttonRow);
        }


        $this->bot->sendMessage(text: __('messages.set_faculty'), reply_markup: $keyboard);
    }

    function run()
    {
        $this->bot->sendMessage(text: __('messages.set_faculty_error'),parse_mode: ParseMode::HTML);
    }
}
