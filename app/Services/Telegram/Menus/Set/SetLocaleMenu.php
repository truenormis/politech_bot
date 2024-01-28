<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class SetLocaleMenu extends Menu
{
    protected string $name = 'init.set_locale';
    function transfer()
    {
        $api = app(ApiService::class);
        $locale = [
            'ru' => '🇷🇺', // Россия
            'ua' => '🇺🇦', // Украина
        ];
        $buttons = [];
        foreach ($locale as $key => $lang) {
            $callback = json_encode(['method' => 'set_lang','data' => $key]);
            $buttons[] = ['text' => $lang, 'callback_data' => $callback];
        }

        $buttons = array_chunk($buttons, 2);
        $keyboard = $this->bot->createInlineKeyboard($buttons);

        $this->bot->sendMessageHTML($this->user->chat_id,__('messages.set_lang'),$keyboard);
    }

    function run()
    {
        $this->bot->sendMessageHTML(
            $this->user->chat_id,
            __('messages.set_lang_error')
        );
    }
}
