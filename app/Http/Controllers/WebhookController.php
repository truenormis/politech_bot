<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\Telegram\TelegramDirector;

use App\Telegram\Callback;
use Illuminate\Support\Facades\Auth;
use SergiX44\Nutgram\Nutgram;

class WebhookController extends Controller
{

    public function __invoke(Nutgram $bot): void
    {

        $bot->onCommand('start', function (Nutgram $bot){
            $user = User::where('chat_id', $bot->user()->id)->first();
            if ($user){
                $user->delete();
            }
            $tg = new TelegramDirector();
            $tg($bot);
        });

        $bot->onMessage(TelegramDirector::class);
        $bot->onCallbackQuery(function (Nutgram $bot){
            Auth::login(User::firstOrCreate(['chat_id'=>$bot->user()->id]));
            app()->setLocale(auth()->user()->locale);
            $callback = new Callback();
            $bot->answerCallbackQuery($bot->callbackQuery()->id, "Ok!");

        });
        $bot->run();
    }

}
