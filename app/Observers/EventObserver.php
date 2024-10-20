<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;

readonly class EventObserver
{

    public function __construct(
        private CacheRepository  $cache,
        private ConfigRepository $config,
    )
    {
    }

    public function created(Event $event): void
    {
        $arrayEvents = $this->cache->get($this->config->get('cache.keys.events.send'));
        $arrayEvents[$event->id] = $event->toArray();
        $this->cache->put($this->config->get('cache.keys.events.send'), $arrayEvents);
    }

    public function updated(Event $event): void
    {
        $arrayEvents = $this->cache->get($this->config->get('cache.keys.events.send'));
        $arrayEvents[$event->id] = $event->toArray();
        $this->cache->put($this->config->get('cache.keys.events.send'), $arrayEvents);
    }

    public function deleted(Event $event): void
    {
        $arrayEvents = $this->cache->get($this->config->get('cache.keys.events.send'));
        $arrayEvents[$event->id] = $event->toArray();
        $this->cache->put($this->config->get('cache.keys.events.send'), $arrayEvents);
    }

}
