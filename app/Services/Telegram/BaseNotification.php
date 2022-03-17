<?php

namespace App\Services\Telegram;

use Exception;

abstract class BaseNotification
{
    /**
     * List of allowed privilege's aliases that
     * can receive this notification.
     *
     * Allowed values: main_admin, reservation_manager, transfer_manager
     *
     * @var array
     */
    protected array $allowedPrivileges;

    /**
     * Driver class name.
     *
     * @var string
     */
    protected string $driverClass;

    /**
     * Get driver instance.
     *
     * @return TelegramDriver
     * @throws Exception
     */
    public final function getDriver(): TelegramDriver
    {
        if (!isset($this->driverClass)) {
            throw new Exception('Not specified driver class!');
        }

        if (!class_exists($this->driverClass)) {
            throw new Exception('Driver not found!');
        }


        return new $this->driverClass($this);
    }

    /**
     * Get allowed privileges aliases.
     *
     * @return array
     * @throws Exception
     */
    public final function getPrivilegeAliases(): array
    {
        if (!isset($this->allowedPrivileges)) {
            throw new Exception('Notification privileges have not been set!');
        }

        return $this->allowedPrivileges;
    }
}