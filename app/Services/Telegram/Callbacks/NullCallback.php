<?php

namespace App\Services\Telegram\Callbacks;

use App\Telegram\Callback;


class NullCallback implements CallbackHandlerInterface
{

    public function handle(Callback $callback)
    {
    }
}
