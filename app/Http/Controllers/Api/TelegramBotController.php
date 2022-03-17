<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TelegramChat;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramBotController extends Controller
{
    public function webhook()
    {
        /** @var Update $update */
        $update = Telegram::commandsHandler(true);

        # If user send his phone number
        if ($update->getMessage()->contact) {
            $chatId = $update->getChat()->id;
            $phoneNumber = $update->getMessage()->contact->get('phone_number');

            if (!$tgChat = TelegramChat::byPhone($phoneNumber)->first()) {
                Telegram::sendMessage([
                    'chat_id' => $update->getChat()->id,
                    'text' => 'Вашего номера нет в базе Alitasin!'
                ]);

                return;
            }

            if (!$tgChat->telegram_chat_id) {
                $tgChat->telegram_chat_id = $chatId;

                if ($tgChat->save()) {
                    Telegram::sendMessage([
                        'chat_id' => $update->getChat()->id,
                        'text' => 'Вы успешно авторизовались в боте Alitasin! Теперь вы можете видеть доступные вам уведомления здесь.'
                    ]);
                } else {
                    Telegram::sendMessage([
                        'chat_id' => $update->getChat()->id,
                        'text' => 'Произошла ошибка... Попробуйте авторизоваться чуть позже!'
                    ]);
                }

                return;
            }

            Telegram::sendMessage([
                'chat_id' => $update->getChat()->id,
                'text' => 'Вы уже авторизованны в боте Alitasin!'
            ]);
        }
    }
}
