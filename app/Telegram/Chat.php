<?php

namespace App\Telegram;


use Illuminate\Support\Collection;

class Chat
{
    public int $id;
    public string $username;
    public function __construct(Collection $chat)
    {
        $this->id = $chat->get('id');
        $this->username = $chat->has('username') ? $chat->get('username') : "";
    }
}
