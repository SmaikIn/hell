<?php

namespace App\Console\Commands;

use App\Events\SendToTelegramEvent;
use Carbon\Carbon;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

class sendEventCommand extends Command
{
    protected $signature = 'send:event';

    protected $description = 'Command description';

    public function handle(): void
    {
        $cache = resolve(CacheRepository::class);
        $config = resolve(ConfigRepository::class);
        $dispatcher = resolve(Dispatcher::class);
        $time = Carbon::now()->addHours(3);

        $arrayEvents = $cache->get($config->get('cache.keys.events.send'));
        $events = [];
        foreach ($arrayEvents as $event) {
            $carbon = Carbon::parse($event['start_time']);
            // Сохраняем оригинальное значение времени;
            if ($carbon->timestamp >= ($time->timestamp - Carbon::parse('5 minutes')->timestamp)) {
                // Осталось 5 минут до начала события
                $dispatcher->dispatch(new SendToTelegramEvent(
                    title: $event['title'],
                    message: $event['description'],
                    start: $carbon,
                    end: Carbon::parse($event['end_time']),
                    chat_id: 362569008,
                ));
                $events[$event['id']] = $event;
            } elseif ($carbon->timestamp >= ($time->timestamp - Carbon::parse('1 hour')->timestamp)) {
                // Остался 1 час до начала события
                $dispatcher->dispatch(new SendToTelegramEvent(
                    title: $event['title'],
                    message: $event['description'],
                    start: $carbon,
                    end: Carbon::parse($event['end_time']),
                    chat_id: 362569008,
                ));
                $events[$event['id']] = $event;
            } elseif ($carbon->timestamp <= $time->timestamp) {
                // Событие началось или уже прошло
                $dispatcher->dispatch(new SendToTelegramEvent(
                    title: $event['title'],
                    message: $event['description'],
                    start: Carbon::parse($event['start_time']),
                    end: Carbon::parse($event['end_time']),
                    chat_id: 362569008,
                ));
            } else {
                $events[$event['id']] = $event;
            }

        }

        $cache->put($config->get('cache.keys.events.send'), $events);
    }
}
