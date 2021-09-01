<?php

namespace App\Telegram\Notifications;

use App\Services\Telegram\Notifications\MessageNotification;

class TourReservationNotification extends MessageNotification
{
    protected array $allowedPrivileges = ['main_admin', 'reservation_manager'];

    /**
     * @inheritDoc
     */
    public function generateText(): string
    {
        return 'Создан новый тур!';
    }
}