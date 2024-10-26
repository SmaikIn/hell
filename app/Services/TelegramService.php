<?php

declare(strict_types=1);

namespace App\Services;


use Carbon\Carbon;
use Telegram\Bot\Api;

final readonly class TelegramService
{
    public function __construct(
        private Api $telegram
    )
    {
    }

    public function sendEvent(array $data): void
    {
        $text = view('telegram.event', [
            'title' => $data['title'],
            'description' => $data['description'],
            'color' => $data['color'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ])->render();

        $this->telegram->sendMessage([
                'chat_id' => $data['chat_id'],
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]
        );


    }
}
