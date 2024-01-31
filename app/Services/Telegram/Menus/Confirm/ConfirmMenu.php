<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Helpers\Md;
use App\Models\User;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use function Laravel\Prompts\text;

class ConfirmMenu extends Menu
{
    protected string $name = 'init.confirm';

    function transfer()
    {
        $api = app(ApiService::class);

        $user = auth()->user();

        $faculty = $api->getFaculties()->where('Key',$user->faculty)->pluck('Value')->first();
        $education_form = $api->getEducationForms()->where('Key',$user->education_form)->pluck('Value')->first();
        $course = $api->getCourses()->where('Key',$user->course)->pluck('Value')->first();
        $group = $api->getGroups($user->faculty,$user->education_form,$user->course)->where('Key',$user->group)->pluck('Value')->first();
        $faculty = $faculty == "Аспірантура_" ? "Аспірантура": $faculty;

        $data = [
            'faculty' => $faculty,
            'education_form' => $education_form,
            'course' => $course,
            'group' => $group,
        ];

        //$this->bot->sendMessageHTML(1983524521, json_encode($data));

        try {
            $view = (string) view('confirm')->with($data);
            $res = $this->bot->sendMessage(text: $view, parse_mode: ParseMode::HTML, reply_markup: $this->getKeyboard());

        } catch (\Exception $e) {
            //$this->bot->sendMessageHTML(1983524521, $e->getMessage());

        }


    }

    function run(): void
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage(text: __("confirm_text_error"),parse_mode: ParseMode::HTML);

    }
}
