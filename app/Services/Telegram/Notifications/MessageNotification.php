<?php

namespace App\Services\Telegram\Notifications;

use App\Services\Telegram\BaseNotification;
use App\Services\Telegram\Drivers\MessageDriver;

abstract class MessageNotification extends BaseNotification
{
    protected string $driverClass = MessageDriver::class;

    public function generateParseMode(): string
    {
        return 'HTML';
    }

    /**
     * Generate message of notification.
     *
     * @return string
     */
    abstract public function generateText(): string;
}