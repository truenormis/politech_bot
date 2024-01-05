<?php

namespace App\Services\Telegram\Menus\Confirm;

use App\Helpers\Md;
use App\Models\User;
use App\Services\Api\ApiService;
use App\Services\Telegram\Menus\Menu;

class ConfirmMenu extends Menu
{
    protected string $name = 'init.confirm';

    protected array $keyboard = [
        [
            'Да' => ConfirmTrueMenu::class,
            'Нет' => ConfirmFalseMenu::class,
        ]

    ];
    function transfer()
    {
        $api = app(ApiService::class);

        $user = User::where('chat_id', $this->message->chat->id)->first();

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
        $data = Md::escapeSpecialCharactersInArray($data);
        //$this->bot->sendMessageHTML(1983524521, json_encode($data));

        try {
            $view = (string) view('confirm')->with($data);
        } catch (\Exception $e) {
            //$this->bot->sendMessageHTML(1983524521, $e->getMessage());

        }
        $res = $this->bot->sendMessage($this->user->chat_id,$view,$this->getKeyboard());


    }

    function run(): void
    {
        if ($this->checkKeyboard()) {
            return;
        }
        $this->bot->sendMessage($this->user->chat_id,"Пожалуйста выберете *Да* или *Нет*");

    }
}
