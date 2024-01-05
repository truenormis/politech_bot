<?php

namespace App\Telegram;

use App\Services\Telegram\CallbackHandlerFactory;
use Illuminate\Support\Collection;

class Callback
{
    public string $method;
    public string $data;
    public Message $message;
    public int $id = 10000;


    /**
     * @param Collection $collect
     */
    public function __construct(Collection $callback)
    {
        $data = json_decode($callback->get('data'));
        $this->id = $callback->get('id');
        $this->method = $data->method;
        $this->data = $data->data;
        $this->message = new Message(collect($callback->get('message')));

        $handler = CallbackHandlerFactory::createHandler($this);
        $handler->handle($this);
    }
}
