<?php

namespace App\Telegram\Notifications;

use App\Services\Telegram\Notifications\MessageNotification;

class TestNotification extends MessageNotification
{
    protected string $name;

    protected array $allowedPrivileges = ['main_admin'];

    /**
     * TestNotification class constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function generateText(): string
    {
        return "*Тестирование бота* \n\n\rЗнач\. параметра: $this->name";
    }
}