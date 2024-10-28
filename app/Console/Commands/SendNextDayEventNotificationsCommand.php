<?php

namespace App\Console\Commands;

use App\Events\SendToTelegramEvent;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;
use Telegram\Bot\Api;

class SendNextDayEventNotificationsCommand extends Command
{
    protected $signature = 'send:next-day-event-notifications';

    protected $description = 'Command description';

    public function handle(): void
    {

        $dispatcher = resolve(Dispatcher::class);
        // Получаем дату следующего дня
        $tomorrow = Carbon::tomorrow();

        // Получаем события, которые запланированы на завтра
        $events = Event::whereDate('start_time', $tomorrow)->get();


        if($events->count() > 0) {
            $tg = resolve(Api::class);
            $text = view('telegram.evening-event')->render();
            $tg->sendMessage([
                'chat_id' => -1002472839215,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]);
            $tg->sendMessage([
                'chat_id' => -1002224260721,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]);
        }

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
        }
    }
}
