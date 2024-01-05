<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class SetEducationFormMenu extends Menu
{
    protected string $name = 'init.set_education_form';
    function transfer()
    {
        $api = app(ApiService::class);
        $educationForms = $api->getEducationForms();
        $buttons = [];
        foreach ($educationForms as $educationForm) {
            $callback = json_encode(['method' => 'set_education_form','data' => $educationForm['Key']]);
            $buttons[] = ['text' => $educationForm['Value'], 'callback_data' => $callback];
        }

        $buttons = array_chunk($buttons, 2);
        $keyboard = $this->bot->createInlineKeyboard($buttons);

        $this->bot->sendMessageHTML($this->user->chat_id,"Выберите форму обучения 🌞/🌜:",$keyboard);
    }

    function run()
    {
        $this->bot->sendMessageHTML($this->user->chat_id,"⚠️ <b>Внимание!</b> Пожалуйста, выберите форму обучения:");
    }
}
