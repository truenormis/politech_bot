<?php

namespace App\Telegram;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 *
 */
class Message
{
    /**
     * @var string|\Closure|null
     */
    public string $text;
    /**
     * @var Chat
     */
    public Chat $chat;
    /**
     * @var Carbon
     */
    public Carbon $date;
    public int $message_id;

    /**
     * @param Collection $message
     */
    public function __construct(Collection $message)
    {
        //dd($message);
        $this->text = $message->has('text') ? $message->get('text') : "";
        $this->chat = new Chat(collect($message->get('chat')));
        $this->date = Carbon::createFromTimestamp($message->get('date'));
        $this->message_id = $message->get('message_id');
    }


}
