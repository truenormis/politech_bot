<?php

namespace App\Services\Telegram\Callbacks;

use App\Telegram\Callback;

interface CallbackHandlerInterface
{
    public function handle(Callback $callback);
}
