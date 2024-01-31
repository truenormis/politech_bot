<?php

namespace App\Services\Telegram\Menus\Set;

use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class SetCourseMenu extends Menu
{
    protected string $name = 'init.set_course';
    function transfer()
    {
        $api = app(ApiService::class);
        $courses = $api->getCourses();
        $keyboard = InlineKeyboardMarkup::make();
        $buttonRow = [];

        foreach ($courses as $faculty) {
            $callback = json_encode(['method' => 'set_course','data' => $faculty['Key']]);
            $buttonRow[] = InlineKeyboardButton::make($faculty['Value'], callback_data: $callback);
            if (count($buttonRow) == 2) {
                $keyboard->addRow(...$buttonRow);
                $buttonRow = [];
            }
        }
        if (!empty($buttonRow)) {
            $keyboard->addRow(...$buttonRow);
        }

        $this->bot->sendMessage(text: __("messages.course"),reply_markup: $keyboard);
    }

    function run()
    {
        $this->bot->sendMessage(text: __("messages.course_error"),parse_mode: ParseMode::HTML);
    }
}
