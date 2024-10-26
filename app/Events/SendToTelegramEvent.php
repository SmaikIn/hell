<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

final readonly class SendToTelegramEvent
{
    use Dispatchable;

    public function __construct(
        private string $title,
        private string $description,
        private string $color,
        private Carbon $start,
        private Carbon $end,
        private string $chat_id,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getStart(): Carbon
    {
        return $this->start;
    }

    public function getEnd(): Carbon
    {
        return $this->end;
    }

    public function getChatId(): string
    {
        return $this->chat_id;
    }

}
