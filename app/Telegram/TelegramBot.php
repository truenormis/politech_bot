<?php

namespace App\Telegram;

use Illuminate\Support\Facades\Http;
use Str;

class TelegramBot
{

    private string $url;
    public function __construct()
    {
        $this->url = "https://api.telegram.org/bot".config('app.bot_api')."/";
    }

    public function sendMessage(int $chatId, $message, $replymarkup = null) {
        if ($replymarkup != null) {
            $data = ['chat_id' => $chatId, 'text' => $message, 'reply_markup' => $replymarkup,'parse_mode' => 'MarkdownV2'];
        } else {
            $data = ['chat_id' => $chatId, 'text' => $message,'parse_mode' => 'MarkdownV2'];
        }
        return $this->useMethod('sendMessage', $data);
    }
    public function sendMessageHTML(int $chatId, $message, $replymarkup = null) {
        if ($replymarkup != null) {
            $data = ['chat_id' => $chatId, 'text' => $message, 'reply_markup' => $replymarkup,'parse_mode' => 'HTML'];
        } else {
            $data = ['chat_id' => $chatId, 'text' => $message,'parse_mode' => 'HTML'];
        }
        return $this->useMethod('sendMessage', $data);
    }


    public function deleteMessage(Message $message){
        return $this->useMethod('deleteMessage', ['chat_id' => $message->chat->id,'message_id' => $message->message_id]);

    }
    public function answerCallbackQuery(Callback $callback){
        return $this->useMethod('answerCallbackQuery', ['callback_query_id' => $callback->id,'text'=>"hiiii"]);

    }

    public function getUpdates(int $offset = -1): TelegramRequest
    {
        $botRequest = new TelegramRequest($this->useMethod('getUpdates', ['offset' => $offset])['result']);

        return $botRequest;
    }

    public function getUpdateId(): int
    {
        return collect($this->useMethod('getUpdates')['result'])->last()['update_id'];
    }

    private function useMethod(string $methodName, array $param = []){
        $methodUri = $this->url.$methodName;
        $http = Http::post($methodUri,$param);
        return $http->json();
    }

    public function createInlineKeyboard(array $buttons) {
        $keyboard = ['inline_keyboard' => $buttons];
        return json_encode($keyboard);
    }
}

