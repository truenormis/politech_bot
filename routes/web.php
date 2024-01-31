<?php


use App\Http\Controllers\BotController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/dev/bot', BotController::class);

Route::post('/bot/webhook', \App\Http\Controllers\WebhookController::class);

Route::get('/', function () {
    $path = (asset('img/11BETA.png'));
    return $path;
});

