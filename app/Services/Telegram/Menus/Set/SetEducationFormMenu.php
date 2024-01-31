<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class SetEducationFormMenu extends Menu
{
    protected string $name = 'init.set_education_form';
    function transfer()
    {
        $api = app(ApiService::class);
        $educationForms = $api->getEducationForms();
        $keyboard = InlineKeyboardMarkup::make();
        $buttonRow = [];
        foreach ($educationForms as $faculty) {
            $callback = json_encode(['method' => 'set_education_form','data' => $faculty['Key']]);
            $buttonRow[] = InlineKeyboardButton::make($faculty['Value'], callback_data: $callback);
            if (count($buttonRow) == 2) {
                $keyboard->addRow(...$buttonRow);
                $buttonRow = [];
            }
        }
        if (!empty($buttonRow)) {
            $keyboard->addRow(...$buttonRow);
        }

        $this->bot->sendMessage(text: __("messages.education_form"),reply_markup:  $keyboard);
    }

    function run()
    {
        $this->bot->sendMessage(text: __("messages.education_form_error"),parse_mode: ParseMode::HTML);
    }
}
