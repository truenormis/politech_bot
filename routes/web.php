<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function (\App\Services\Api\ApiService $api,\App\Telegram\TelegramBot $bot) {
//    $faculty = $api->getFaculties()->get(3)['Key'];
//    $educationForm = $api->getEducationForms()->get(0)['Key'];
//    $course = $api->getCourses()->get(1)['Key'];
//    $group = $api->getGroups($faculty,$educationForm,$course)->get(4)['Key'];
//    dd($api->schedule($group)->getNextWeek());
    foreach ($bot->getUpdates()->getMessages() as $message){
        $bot->sendMessage($message->chat->id,$message->text);
    };
});
