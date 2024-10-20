<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class TelegramController extends Controller
{

    public function __construct(
        private readonly Api $telegram
    ){
    }

    public function index()
    {
        $response = $this->telegram->getUpdates();

        dump($response);
        foreach ($response as $item) {
            $this->telegram->sendMessage(
                [
                    'chat_id' => $item->getChat()->get('id'),
                    'text' => 'Я жив',
                ]
            );
        }
    }
}
