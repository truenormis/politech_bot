<?php

namespace App\Services\Telegram\Menus;

use App\Models\User;
use App\Services\Telegram\Keyboard;
use App\Telegram\Message;
use App\Telegram\TelegramBot;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

abstract class Menu
{
    protected array $keyboard;
    protected string $name;
    protected ?\Illuminate\Contracts\Auth\Authenticatable $user;
    //protected Message $message;
    protected Nutgram $bot;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->keyboard = app(Keyboard::class)->getKeyboard($this);

        $this->user = auth()->user();
        $this->bot = app(Nutgram::class);
        if ($this->user->menu != $this->name){
            $this->user->update(['menu'=>$this->name]);
            $this->transfer();
        }elseif (!$this->checkKeyboard())
        {
            $this->run();
        }

    }

    private function keyboardNavigateToMenu(string $text, array $currentKeyboard): bool
    {
        foreach ($currentKeyboard as $key => $value) {
            if ($key === $text) {
                $menuClass = $value;
                $menu = new $menuClass();
                return true; // Класс меню найден
            } elseif (is_array($value)) {
                // Рекурсивный вызов для вложенных массивов
                if ($this->keyboardNavigateToMenu($text, $value)) {
                    return true; // Класс меню найден в рекурсивном вызове
                }
            }
        }

        return false; // Класс меню не найден
    }


    protected function getKeyboard(): ReplyKeyboardMarkup
    {

        //Log::channel('telegram')->info('Hello world!', $this->keyboard);


        if (!$this->keyboard || !is_array($this->keyboard)) {
            throw new \InvalidArgumentException('Invalid keyboard configuration');
        }

        $keyboard = ReplyKeyboardMarkup::make();

        foreach ($this->keyboard as $key => $value) {
            if (is_array($value)) {
                $keyboardRow = [];
                foreach ($value as $nestedKey => $nestedValue) {
                    // Добавляем текст для кнопки
                    $keyboardRow[] = KeyboardButton::make($nestedKey);
                }
                $keyboard->addRow(...$keyboardRow);
            } else {
                $button = KeyboardButton::make($key);
                $keyboard->addRow($button);
            }
        }

        return $keyboard;
    }

    protected function checkKeyboard(): bool
    {
        if (!$this->keyboard) {
            return false;
        }
        return $this->keyboardNavigateToMenu($this->bot->message()->text,$this->keyboard);

    }
    abstract function transfer();

    abstract function run();
}
