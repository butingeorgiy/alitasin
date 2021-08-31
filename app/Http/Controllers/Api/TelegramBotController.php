<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramBotController extends Controller
{
    public function webhook()
    {
        /** @var Update $update */
        $update = Telegram::commandsHandler(true);

        Telegram::sendMessage([
            'chat_id' => $update->getChat()->id,
            'text' => print_r($update)
        ]);

//        Log::info('Telegram Contact: ', ['data' => $update->getChat()]);
    }
}
