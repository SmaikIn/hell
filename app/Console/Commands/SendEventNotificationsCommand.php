<?php

namespace App\Console\Commands;

use App\Events\SendToTelegramEvent;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class SendEventNotificationsCommand extends Command
{
    protected $signature = 'send:event-notifications';

    protected $description = 'Command description';

    public function handle(): void
    {
        $dispatcher = resolve(Dispatcher::class);
        // Получаем текущее время плюс 1 час
        $now = Carbon::now();
        $oneHourFromNow = $now->copy()->addHour();

        // Получаем события, которые начинаются через час
        $events = Event::whereBetween('start_time', [$now, $oneHourFromNow])->where('is_hour', false)->get();

        foreach ($events as $event) {
            $dispatcher->dispatch(new SendToTelegramEvent(
                title: $event->title,
                description: $event->description,
                color: $event->color,
                start: Carbon::parse($event->start_time),
                end: Carbon::parse($event->end_time),
                chat_id: -1002472839215,
            ));
            $dispatcher->dispatch(new SendToTelegramEvent(
                title: $event->title,
                description: $event->description,
                color: $event->color,
                start: Carbon::parse($event->start_time),
                end: Carbon::parse($event->end_time),
                chat_id: -1002224260721,
            ));
            $event->is_hour = true;
            $event->save();
        }
    }
}
