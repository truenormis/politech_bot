<?php

namespace App\Services\Telegram;

use App\Models\User;
use App\Telegram\Message;

class TelegramDirector
{
    public function __construct(private Message $message)
    {
        $user = $this->userCheck();
        app()->setLocale($user->locale);
        //dd(1);
        MenuHandlerFactory::createHandler($user,$this->message);
    }

    private function userCheck() : User{
        $user = User::where('chat_id',$this->message->chat->id)->first();
        if ($user === null){
            $user = User::create(['chat_id' => $this->message->chat->id]);
        }
        return $user;
    }



}
