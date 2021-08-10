<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function webhook()
    {
        $updates = Telegram::getWebhookUpdates();

        Log::info('Telegram Webhook Updates: ', ['data' => $updates]);
    }
}
