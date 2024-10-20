<?php

declare(strict_types=1);

namespace App\Services;


use Carbon\Carbon;
use Telegram\Bot\Api;

final readonly class TelegramService
{
    public function __construct(
        private readonly Api $telegram
    )
    {
    }

    public function sendEvent(array $data): void
    {

        $text = view('telegram.messageEvent', [
            'dateStart' => Carbon::parse($data['start']),
            'dateEnd' => Carbon::parse($data['end']) ,
            'title' =>  $data['title'],
            'message' => $data['message'],
        ])->render();

        $this->telegram->sendMessage([
                'chat_id' => $data['chat_id'],
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]
        );
    }
}
