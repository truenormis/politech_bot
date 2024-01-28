<?php

namespace App\Services\Telegram\Menus;

use App\Models\User;
use App\Services\Telegram\Keyboard;
use App\Telegram\Message;
use App\Telegram\TelegramBot;

abstract class Menu
{
    protected array $keyboard;
    protected string $name;

    protected Message $message;
    protected User $user;
    protected TelegramBot $bot;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __construct(Message $message)
    {
        $this->keyboard = app(Keyboard::class)->getKeyboard($this);
        $this->message = $message;
        $this->user = User::where('chat_id',$message->chat->id)->first();
        $this->bot = app(TelegramBot::class);
        if ($this->user->menu != $this->name){
            $this->user->update(['menu'=>$this->name]);
            $this->transfer();
        }else{
            $this->run();
        }

    }

    private function keyboardNavigateToMenu(string $text, array $currentKeyboard): bool
    {
        foreach ($currentKeyboard as $key => $value) {
            if ($key === $text) {
                $menuClass = $value;
                $menu = new $menuClass($this->message);
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


    protected function getKeyboard(): array
    {


        if (!$this->keyboard || !is_array($this->keyboard)) {
            throw new \InvalidArgumentException('Invalid keyboard configuration');
        }

        $transformedKeyboard = [];

        foreach ($this->keyboard as $key => $value) {
            if (is_array($value)) {
                $transformedValue = [];
                foreach ($value as $nestedKey => $nestedValue) {
                    // Добавляем текст для кнопки
                    $transformedValue[] = ['text' => $nestedKey];
                }
                $transformedKeyboard['keyboard'][] = $transformedValue;
            } else {
                $transformedValue[] = ['text' => $key];
                // Преобразование основного массива
                $transformedKeyboard['keyboard'][] = $transformedValue;
            }
        }

        return $transformedKeyboard;
    }

    protected function checkKeyboard(): bool
    {
        return $this->keyboardNavigateToMenu($this->message->text,$this->keyboard);

    }
    abstract function transfer();

    abstract function run();
}
