<?php

namespace App\Listeners;

use App\Events\SendToTelegramEvent;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendToTelegramListener implements ShouldQueue
{

    public ?string $queue = 'default';

    public function __construct(
        private readonly TelegramService $telegramService
    )
    {
    }

    public function handle(SendToTelegramEvent $event): void
    {
        $data = [];
        $data['title'] = $event->getTitle();
        $data['chat_id'] = $event->getChatId();
        $data['description'] = $event->getDescription();
        $data['end_time'] = $event->getEnd()->format('d.m H:i');
        $data['start_time'] = $event->getStart()->format('d.m H:i');
        $data['color'] = $event->getColor();

        $this->telegramService->sendEvent($data);
    }
}
