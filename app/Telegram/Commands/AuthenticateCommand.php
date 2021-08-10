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
        $keyboard = Keyboard::make()
            ->inline()
            ->row(
                Keyboard::inlineButton(['text' => 'Отправить номер телефона', 'request_contact' => true]),
            );

        $this->replyWithMessage([
            'text' => 'Отправьте номер телефона текущего аккаунта ' .
                'Telegram для проверки доступа в системе AliTasin.',
            'reply_markup' => $keyboard
        ]);
    }
}