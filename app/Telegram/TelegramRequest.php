<?php

namespace App\Telegram;

use Illuminate\Support\Collection;

/**
 * @template T
 */
class TelegramRequest
{
    public function __construct(private readonly array $data)
    {
    }

    /**
     * @return Collection<Message<T>>
     */
    public function getMessages(): Collection
    {
        $messages = collect();
        foreach ($this->data as $mes) {
            if (isset($mes['message'])) {
                $messages->add(new Message(collect($mes['message'])));
            }
        }
        return $messages;
    }

    /**
     * @return Collection<Callback<T>>
     */
    public function getCallbacks(): Collection
    {
        $callback = collect();
        foreach ($this->data as $mes) {
            if (isset($mes['callback_query'])) {
                $callback->add(new Callback(collect($mes['callback_query'])));
            }
        }
        return $callback;
    }

    public function getMessage(): ?Message
    {
        if (isset($this->data['message'])) {
            $massage = new Message(collect($this->data['message']));
            return $massage;
        }
        return null;
    }

    public function getCallback(): ?Callback
    {
        if (isset($this->data['callback_query'])) {
            $callback = new Callback(collect($this->data['callback_query']));
            return $callback;
        }
        return null;
    }

}
