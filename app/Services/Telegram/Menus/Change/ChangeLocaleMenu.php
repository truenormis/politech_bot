<?php

namespace App\Services\Telegram\Menus\Change;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class ChangeLocaleMenu extends Menu
{
    protected string $name = 'init.set_locale';
    function transfer()
    {

        $keyboard = InlineKeyboardMarkup::make();
        $locale = [
            'ru' => '🇷🇺',
            'ua' => '🇺🇦',
        ];
        foreach (array_chunk($locale, 2, true) as $buttonRow) {
            $row = [];
            foreach ($buttonRow as $text => $key) {
                $callback = json_encode(['method' => 'change_lang','data' => $text]);

                $row[] = InlineKeyboardButton::make($key, callback_data: $callback);
            }
            $keyboard->addRow(...$row);
        }
        $this->bot->sendMessage(text: __('messages.set_lang'), parse_mode: ParseMode::HTML, reply_markup: $keyboard);
    }

    function run()
    {
        $this->bot->sendMessage(text: __('messages.set_lang_error'), parse_mode: ParseMode::HTML);

    }
}
