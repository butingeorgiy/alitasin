<?php

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Str;
use Telegram\Bot\Objects\Message;

abstract class TelegramDriver
{
    /** @var int */
    protected int $recipient;

    /**
     * Telegram Notification instance.
     *
     * @var BaseNotification
     */
    protected BaseNotification $notification;

    /**
     * Telegram Response instance.
     *
     * @var Message
     */
    protected Message $response;

    /**
     * Constructor of TelegramDriver class.
     *
     * @param BaseNotification $notification
     */
    public function __construct(BaseNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get Telegram Response instance.
     *
     * @return Message
     * @throws Exception
     */
    public final function getResponse(): Message
    {
        if (!isset($this->response)) {
            throw new Exception('Telegram response has not been set!');
        }

        return $this->response;
    }

    /**
     * Set recipient as chat ID.
     *
     * @param int $chatId
     */
    public final function setRecipient(int $chatId): void
    {
        $this->recipient = $chatId;
    }

    /**
     * Get recipient as chat ID.
     *
     * @return int
     * @throws Exception
     */
    public final function getRecipient(): int
    {
        if (!isset($this->recipient)) {
            throw new Exception('Recipient ID has not been set!');
        }

        return $this->recipient;
    }

    /**
     * Prepare params for request.
     *
     * @return array
     */
    protected function prepareParams(): array
    {
        $methods = get_class_methods($this->notification);

        foreach ($methods as $method) {
            if (Str::startsWith($method, 'generate')) {
                $paramName = Str::snake(Str::after($method, 'generate'));
                $paramValue = call_user_func_array([$this->notification, $method], []);

                if ($paramValue !== null) {
                    $params[$paramName] = $paramValue;
                }
            }
        }

        return $params ?? [];
    }

    abstract public function send(): void;
}