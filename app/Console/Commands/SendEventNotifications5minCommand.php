<?php

namespace App\Console\Commands;

use App\Events\SendToTelegramEvent;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class SendEventNotifications5minCommand extends Command
{
    protected $signature = 'send:event-notifications';

    protected $description = 'Command description';

    public function handle(): void
    {
        $dispatcher = resolve(Dispatcher::class);
        // Получаем текущее время плюс 5 минут
        $now = Carbon::now();
        $oneHourFromNow = $now->copy()->addMinutes(5);

        // Получаем события, которые начинаются через 5 минут
        $events = Event::whereBetween('start_time', [$now, $oneHourFromNow])->get();

        foreach ($events as $event) {
            $dispatcher->dispatch(new SendToTelegramEvent(
                title: $event->title,
                description: $event->description,
                color: $event->color,
                start: Carbon::parse($event->start_time),
                end: Carbon::parse($event->end_time),
                chat_id: -1002472839215,
            ));
            $event->is_send = true;
            $event->save();
        }
    }
}
