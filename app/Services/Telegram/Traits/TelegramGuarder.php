<?php

namespace App\Services\Telegram\Traits;

use App\Models\TelegramChat;
use Illuminate\Database\Eloquent\Collection;

trait TelegramGuarder
{
    /**
     * Retrieve only allowed chat's IDs
     * for sending notification.
     *
     * @return array
     */
    protected function getAllowedRecipients(): array
    {
        /** @var Collection<int> $chats */
        $chats = TelegramChat::select('telegram_chat_id')
            ->whereIn('phone_number', $this->sendTo)
            ->whereNotNull('telegram_chat_id')
            ->whereHas('privileges', function ($query) {
                $query->whereIn('alias', $this->notification->getPrivilegeAliases());
            })->get();

        return $chats->map(function ($item) {
            return $item['telegram_chat_id'];
        })->toArray();
    }
}