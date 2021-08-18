<?php

namespace App\Services\Telegram\Drivers;

use App\Services\Telegram\Notifications\MessageNotification;
use App\Services\Telegram\TelegramDriver;
use Exception;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * @property MessageNotification notification
 */
class MessageDriver extends TelegramDriver
{
    /**
     * Send message to Telegram Bot.
     *
     * @throws Exception
     */
    public function send(): void
    {
        $this->response = Telegram::sendMessage(
            array_merge([
                'chat_id' => $this->getRecipient()
            ], $this->prepareParams())
        );
    }
}