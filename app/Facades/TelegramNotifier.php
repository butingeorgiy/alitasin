<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Telegram\TelegramNotifier as TelegramNotifierClient;

/**
 * @method static TelegramNotifierClient to(string|array $phones)
 */
class TelegramNotifier extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TelegramNotifierClient::class;
    }
}