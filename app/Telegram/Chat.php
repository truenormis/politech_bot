<?php

namespace App\Telegram;



use App\Models\User;
use Illuminate\Support\Collection;

class Chat
{
    public int $id;
    public string $username;
    public function __construct(Collection $chat)
    {
        $this->id = $chat->get('id');
        $this->username = $chat->has('username') ? $chat->get('username') : "";

        $this->setChatLocale();
    }

    private function setChatLocale()
    {
        $user = User::firstOrCreate(['chat_id' => $this->id])->first();
        app()->setLocale($user->locale);
    }
}
