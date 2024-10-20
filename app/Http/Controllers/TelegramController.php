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
        //$response = $this->telegram->getUpdates();
        $this->telegram->sendMessage(
            [
                'chat_id' => '-1002472839215',
                'text' => 'девил чорт',
            ]
        );
        //dump($response);
    }
}
