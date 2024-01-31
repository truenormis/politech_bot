<?php

namespace App\Telegram;

use App\Services\Telegram\CallbackHandlerFactory;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Nutgram;

class Callback
{
    public string $method;
    public string $data;



    /**
     * @param Collection $collect
     */
    public function __construct()
    {
        $bot = app(Nutgram::class);
        $data = json_decode($bot->callbackQuery()->data,true);
        $this->method = $data['method'];
        $this->data = $data['data'];

        $handler = CallbackHandlerFactory::createHandler($this);
        $handler->handle($this);
    }
}
