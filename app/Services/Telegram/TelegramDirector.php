<?php

namespace App\Services\Telegram;

use App\Models\User;
use App\Telegram\Message;
use Illuminate\Support\Facades\Auth;
use SergiX44\Nutgram\Nutgram;

class TelegramDirector
{

    public function __invoke(Nutgram $bot)
    {
        //$bot->sendMessage($bot->message()->text);
        $user = $this->userCheck($bot->user()->id);
        Auth::login($user);
        app()->setLocale($user->locale);
        //dd(1);
        //$bot->sendMessage(app()->getLocale());
        MenuHandlerFactory::createHandler();
    }

    private function userCheck(int $id) : User{
        $user = User::where('chat_id',$id)->first();
        if ($user === null){
            $user = User::create(['chat_id' => $id]);
        }
        return $user;
    }



}
