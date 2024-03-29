<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Callbacks\CallbackHandlerInterface;
use App\Services\Telegram\Callbacks\ChangeLocaleCallback;
use App\Services\Telegram\Callbacks\NullCallback;
use App\Services\Telegram\Callbacks\SetCourseCallback;
use App\Services\Telegram\Callbacks\SetEducationFormCallback;
use App\Services\Telegram\Callbacks\SetFacultyCallback;
use App\Services\Telegram\Callbacks\SetGroupCallback;
use App\Services\Telegram\Callbacks\SetLocaleCallback;
use App\Services\Telegram\Menus\Set\SetLocaleMenu;
use App\Telegram\Callback;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Rfc4122\NilUuid;

class CallbackHandlerFactory
{
    protected static $handlers = [
        'set_faculty' => SetFacultyCallback::class,
        'set_education_form' => SetEducationFormCallback::class,
        'set_course' => SetCourseCallback::class,
        'set_group' => SetGroupCallback::class,
        'set_lang' => SetLocaleCallback::class,
        'change_lang' => ChangeLocaleCallback::class

        // Добавьте другие методы по мере необходимости
    ];

    public static function createHandler(Callback $callback): ?CallbackHandlerInterface
    {
        $method = $callback->method;
        //dd($method);
        if (!Arr::has(static::$handlers, $method)) {
            return new NullCallback();

        }

        $handlerClass = static::$handlers[$method];

        return new $handlerClass();
    }
}
