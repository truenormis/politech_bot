<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramDirector;
use App\Telegram\TelegramBot;
use App\Telegram\TelegramRequest;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function __invoke(Request $request, TelegramBot $bot)
    {
        try {
            //$bot->sendMessageHTML(1983524521, $request->toArray());
            $webhook = new TelegramRequest($request->toArray());
            if (isset($request->toArray()['message'])){
                new TelegramDirector($webhook->getMessage());
            }if (isset($request->toArray()['callback_query'])){
                $callback = $webhook->getCallback();
                //$bot->sendMessageHTML(1983524521, "hiiii");

                $answer = $bot->answerCallbackQuery($callback);
                //$bot->sendMessageHTML(1983524521, $answer);


            }

        } catch (\Exception $e) {
            $errorMessage = 'Произошла ошибка при обработке запроса: ' . $e->getMessage();
            $errorDetails = [
                'Message' => $e->getMessage(),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Trace' => nl2br($e->getTraceAsString()), // Преобразуем символы новой строки в HTML-тег <br>
            ];

            $formattedError = '<pre>' . print_r($errorDetails, true) . '</pre>';

            error_log('Error in Telegram webhook: ' . json_encode($errorDetails));

            $bot->sendMessageHTML(1983524521, $errorMessage . PHP_EOL . $formattedError);
        }
    }

}
