<?php

namespace App\Listeners;

use App\Events\SendToTelegramEvent;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToTelegramListener implements ShouldQueue
{

    public ?string $queue = 'default';

    public function __construct(
        private TelegramService $telegramService
    )
    {
    }

    public function handle(SendToTelegramEvent $event): void
    {
        $data = [];
        $data['title'] = $event->getTitle();
        $data['chat_id'] = $event->getChatId();
        $data['message'] = $event->getMessage();
        $data['end'] = $event->getEnd()->getTimestamp();
        $data['start'] = $event->getStart()->getTimestamp();
        $this->telegramService->sendEvent($data);
    }
}
