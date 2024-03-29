<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class AuthenticateCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'auth';

    /**
     * @var string Command Description
     */
    protected $description = 'Команда для аутентификации в боте.';

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $phoneShareButton = Keyboard::button([
            'text' => 'Отправить номер телефона',
            'request_contact' => true
        ]);

        $keyboard = Keyboard::make([
            'keyboard' => [[$phoneShareButton]],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $this->replyWithMessage([
            'text' => 'Отправьте номер телефона текущего аккаунта ' .
                'Telegram для проверки доступа в системе Ali Tasin.',
            'reply_markup' => $keyboard
        ]);
    }
}