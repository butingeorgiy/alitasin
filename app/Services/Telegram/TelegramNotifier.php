<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Traits\TelegramGuarder;
use App\Services\Telegram\Traits\TelegramQueueable;
use Exception;

class TelegramNotifier
{
    use TelegramGuarder;
    use TelegramQueueable;

    /**
     * List of phone numbers of recipients.
     *
     * @var array
     */
    protected array $sendTo;

    /**
     * Instance of Telegram notification.
     *
     * @var BaseNotification
     */
    protected BaseNotification $notification;

    /**
     * Set list of phone numbers of recipients.
     *
     * @param string|array $phones
     * @throws Exception
     */
    public function to($phones): TelegramNotifier
    {
        $sendTo = [];

        if (gettype($phones) === 'string') {
            $sendTo[] = $phones;
        } else if (gettype($phones) === 'array') {
            $sendTo = $phones;
        } else {
            throw new Exception('Undefined type of $phones argument.');
        }

        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Send notification to Telegram Bot.
     *
     * @param BaseNotification $notification
     * @return TelegramNotifier
     * @throws Exception
     */
    public function send(BaseNotification $notification): TelegramNotifier
    {
        if (!isset($this->sendTo)) {
            throw new Exception('List of recipients has not been initialized!');
        }

        $this->setNotification($notification);

        $driver = $this->getDriver();

        foreach ($this->getAllowedRecipients() as $recipient) {
            $driver->setRecipient($recipient);
            $driver->send();

            $this->setResponse($driver->getResponse());
        }

        return $this;
    }

    /**
     * Set Telegram Notification instance.
     *
     * @param BaseNotification $notification
     */
    protected function setNotification(BaseNotification $notification): void
    {
        $this->notification = $notification;
    }

    /**
     * Get Telegram Notification instance.
     *
     * @return BaseNotification
     * @throws Exception
     */
    protected function getNotification(): BaseNotification
    {
        if (!isset($this->notification)) {
            throw new Exception('Telegram Notification instance has not been set!');
        }

        return $this->notification;
    }

    /**
     * Get notification driver.
     *
     * @return TelegramDriver
     * @throws Exception
     */
    protected function getDriver(): TelegramDriver
    {
        return $this->getNotification()->getDriver();
    }
}